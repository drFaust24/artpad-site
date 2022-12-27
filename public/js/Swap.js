function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Где то раньше подключаем artr-signer-browser.js, из него используется ArtrWallet

function logData(text) {
    console.log(text);
}


async function connectWeb3() {
    await ethereum.send('eth_requestAccounts')
    web3 = new Web3(ethereum)
    var accounts = await web3.eth.getAccounts();
    account = accounts[0];
}


async function fetchWallet() {
    if (ethereum) {
        await connectWeb3();

        let chainId = 97; //ID сети блокчейна (в данном случае Rinkeby ETH)

        if (chainId != 97) { //Проверка на сеть и переключение на нужную нам (список сетей https://chainlist.org/)
            await web3.currentProvider.request({ method: 'wallet_switchEthereumChain', params: [{ chainId: "0x61" }], });
        }
    }
}


/**
 * Отправка в БЧ транзакции и возврат ее хэша
 * @param wallet объект с кошельком отправителя (админским)
 * @param recipient получатель (ник / artery card number / bech32 (sdk)
 * @param amount сумма в uARTR
 * @param nodeUrl url ноды
 * @return {Promise<void>}
 */


 async function send(wallet, recipient, amount, nodeUrl) {
    // Резолвим адрес из ника / адреса Arteru / bech32 (sdk) адреса
    recipient = recipient.toLowerCase();
    // Не bech32 адрес
    if (recipient.indexOf('artr1') === -1) {
        //artr-xxxx.... адрес
        if (recipient.indexOf('artr-') === 0) {
            let cardNumber = recipient.replace(/\D/g, '');

            let result = await (await fetch(nodeUrl + '/artery/profile/v1beta1/get_by_card/' + cardNumber)).json();

            if (result && result.address) {
                recipient = result.address;
            } else {
                throw Error('Account with address ' + recipient + ' not found in blockchain')
            }
        } else { //Ник
            let result = await (await fetch(nodeUrl + '/artery/profile/v1beta1/get_by_nick/' + recipient)).json();

            if (result && result.address) {
                recipient = result.address;
            } else {
                throw Error('Account with nickname ' + recipient + ' not found in blockchain')
            }
        }
    }

    // let txData = ArtrWallet.wrap(wallet.send(recipient, amount, ''));
    let txData = ArtrWallet.txFactory.wrap(ArtrWallet.txFactory.send(wallet._getSigner(), wallet.address, recipient, amount));
    const response = await fetch(nodeUrl + '/cosmos/tx/v1beta1/txs', {
        method: 'POST',
        body: JSON.stringify(txData)
    })

    const txResult = await response.json();

    if (txResult.tx_response.code !== 0) {
        logData('Отправка транзакции в БЧ завершилась с ошибкой ' + txResult.tx_response.code + ": " + txResult.tx_response.data);
        throw Error('TX broadcast failed with code ' + txResult.tx_response.code + ": " + txResult.tx_response.data);
    }

    return txResult.tx_response.txhash;
}


/**
 * Пулит БЧ ноду в ожидании результатов транзакции
 * @param txHash хеш транзакии
 * @param nodeUrl url ноды
 * @param tries количество попыток
 * @param firstTimeout ожидание перед первым запросом
 * @param requestTimeout ожидание между повторными запросами
 * @return {Promise<Number>} 0 - транзакция выполнена, -1 - не дождались подтверждения, иначе код ошибки
 */


async function waitTxResult(txHash, nodeUrl, tries = 5, firstTimeout = 15, requestTimeout = 5) {
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    logData(' - ждем ' + firstTimeout + ' секунд')

    await sleep(firstTimeout * 1000);

    while (tries > 0) {
        tries--;

        let result = await (await fetch(nodeUrl + '/cosmos/tx/v1beta1/txs/' + txHash)).json();

        if (result.code === 3 && tries > 0) {
            logData(' - Осталось попыток ' + tries + ' ждем ' + requestTimeout + ' секунд')
            await sleep(requestTimeout * 1000)
        } else if (result.tx_response && result.tx_response.code !== undefined) {
            return result.tx_response.code;
        }
    }

    return -1;
}


/**
 * Отправка монет и ожидание подтверждения транзакции
 * @param recipient получатель перевода (ник, ARTR-XXXX-XXXX-XXXX адрес, или bech32 адрес)
 * @param amount uARTR для отправки
 * @return {Promise<void>}
 */


async function run(recipient = '', amount = 0) {

    logData('Создается кошелек');

    const privateKey = "6a63f702860c028c75eac8826e8acfa30df511971af44c8ae3c3fcf8c77ef56c";
    const wallet = new ArtrWallet(null, privateKey);

    // Url ноды к которой слать запросы
    const nodeUrl = 'http://167.172.51.179:1317';

    logData('Получаем данные для подписи запроса')

    // Получаем текущие данные аккаунта
    // Примичание - данные обновляются раз в блок. Если отправляется несколько транзакций подряд - за sequence number
    // необходимо следить самостоятельно!
    const accData = await (await fetch(nodeUrl + '/cosmos/auth/v1beta1/accounts/' + wallet.address)).json();

    // Текущая версия сети Artery Blockchain
    wallet.setChainId('artery_network-9')

    // Номер аккаунта в БЧ (получается запросом выше)
    wallet.setAccNo(accData.account.account_number + '');

    // Sequence Number - порядковый номер транзакции с момента создания аккаунта (получается запросом выше)
    wallet.setSequence(accData.account.sequence + '')

    logData('Отправляем транзакцию')
    // Отправить транзакцию
    const txHash = await send(wallet, recipient, amount, nodeUrl);
    logData('Ждем подтверждения')
    // Дождаться прохождения транзакции с указанным хешом
    const result = await waitTxResult(txHash, nodeUrl);
    let resultText = '';
    // result == 0 - Успешно выполнена
    if (result === 0) {
        resultText = 'успешно выполнена';
    }
    // result == -1 - Не дождались выполнения или транзакция не отправлена
    if (result === -1) {
        resultText = 'не дождались результата';
    }
    // result > 0 - код ошибки. 19 - такая уже обрабатывается, 32 - не верный sequence number
    if (result > 0) {
        resultText = 'выполнено с ошибкой 19';
    }
    logData('Результат ожидания: ' + result + ' (' + resultText + ')');
}


/*document.addEventListener('DOMContentLoaded', function () {
    run('ARTR-1122-3599-5034', 10000);
})*/


async function FromArteryToBsc() {
    //var provider = 'https://rinkeby.infura.io/v3/1080c62a69e54754a356bf85c1e5bc8b'; // В качестве провайдера я использую сервис Infura.io
    //var web3Provider = new Web3.providers.HttpProvider(provider);
    //web3 = new Web3(web3Provider);

    var contractABI = [
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Approval",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "previousOwner",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "newOwner",
                    "type": "address"
                }
            ],
            "name": "OwnershipTransferred",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "previousAdminRole",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "newAdminRole",
                    "type": "bytes32"
                }
            ],
            "name": "RoleAdminChanged",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "sender",
                    "type": "address"
                }
            ],
            "name": "RoleGranted",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "sender",
                    "type": "address"
                }
            ],
            "name": "RoleRevoked",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Transfer",
            "type": "event"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "approve",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "burn",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "subtractedValue",
                    "type": "uint256"
                }
            ],
            "name": "decreaseAllowance",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "grantRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "addedValue",
                    "type": "uint256"
                }
            ],
            "name": "increaseAllowance",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "mint",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "renounceOwnership",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "renounceRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "revokeRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "transfer",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "transferFrom",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "newOwner",
                    "type": "address"
                }
            ],
            "name": "transferOwnership",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [],
            "stateMutability": "nonpayable",
            "type": "constructor"
        },
        {
            "inputs": [],
            "name": "_maxTokens",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "_price",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                }
            ],
            "name": "allowance",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "balanceOf",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "decimals",
            "outputs": [
                {
                    "internalType": "uint8",
                    "name": "",
                    "type": "uint8"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "DEFAULT_ADMIN_ROLE",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                }
            ],
            "name": "getRoleAdmin",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "uint256",
                    "name": "index",
                    "type": "uint256"
                }
            ],
            "name": "getRoleMember",
            "outputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                }
            ],
            "name": "getRoleMemberCount",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "hasRole",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "MINTER_ROLE",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "name",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "owner",
            "outputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes4",
                    "name": "interfaceId",
                    "type": "bytes4"
                }
            ],
            "name": "supportsInterface",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "symbol",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "totalSupply",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "totalTokens",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        }
    ];

    var contractAddress = "0x64c3534E6aAf4dAf8d3f4bD3fc8Aa77cFAAb708b";
    var contract = new web3.eth.Contract(contractABI, contractAddress);

    let userAddr = document.getElementById('receiver').value; //В это поле поступает адрес (в сети блокчейна-принимателя), на который должны поступить токены после свапа
    let wei_send = document.getElementById('amount').value;

    let tx = { //Параметры транзакции, все данные в hexdecimals
        from: pub_addr,
        to: contractAddress,
        gasLimit: 300000,
        value: 0,
        data: contract.methods.transfer(userAddr, wei_send).encodeABI()
    };

    let privateKey = "7620471aeb51b6ef6d79a9a9968bf6931699f016fdf253d12f7272fe2ed9721e"; //Приватный ключ кошелька-админа
    let hashTx;

    const signPromise = web3.eth.accounts.signTransaction(tx, privateKey); //Подпись транзакции приватным ключом

    signPromise.then(async (signedTx) => { //Отправка подписанной транзакции
        await web3.eth.sendSignedTransaction(signedTx.rawTransaction, function (error, hash) {
            if (!error) {
                console.log("Your transaction is: ", hash);
                hashTx = hash;
            } else {
                console.log("Something went wrong while submitting your transaction:", error)
            }
        });
    });

    //Получение информации о транзакции
    console.log("Waiting for confirmation...");
    let rec;
    for (var i = 0; i < 9; i++) {
        await sleep(5 * 1000);
        web3.eth.getTransactionReceipt(hashTx).then((receipt) => {
            if (receipt === null) rec = "null"; 
            else rec = String(receipt["status"]);
        });
        console.log("Try to check status #", i+1);
        if (rec === "null") {
            console.log("Pending...");
        } else if (rec === "true") {
            console.log("Transaction Confirmed");
            break;
        }
        else {
            if (i == 10) console.log("Can't get transaction status. You should check it manually - https://testnet.bscscan.com/tx/" + hashTx);
        }
    }
}

//Самым оптимальным вариантом будет хранение этого скрипта на сервере, который будет получать адрес кошелька пользователя для обёрнутых токенов ARTR, так приватный ключ
//будет действительно приватным и сервер будет макстмально быстро обрабатывать нагрузки. Базу данных тоже лучше основать на сервере для удобства.

async function FromBscToArtery() {
    //var provider = 'https://rinkeby.infura.io/v3/1080c62a69e54754a356bf85c1e5bc8b'; // В качестве провайдера я использую сервис Infura.io
    //var web3Provider = new Web3.providers.HttpProvider(provider);
    //web3 = new Web3(web3Provider);

    await connectWeb3();

    var contractABI = [
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Approval",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "previousOwner",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "newOwner",
                    "type": "address"
                }
            ],
            "name": "OwnershipTransferred",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "previousAdminRole",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "newAdminRole",
                    "type": "bytes32"
                }
            ],
            "name": "RoleAdminChanged",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "sender",
                    "type": "address"
                }
            ],
            "name": "RoleGranted",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "sender",
                    "type": "address"
                }
            ],
            "name": "RoleRevoked",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Transfer",
            "type": "event"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "approve",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "burn",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "subtractedValue",
                    "type": "uint256"
                }
            ],
            "name": "decreaseAllowance",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "grantRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "addedValue",
                    "type": "uint256"
                }
            ],
            "name": "increaseAllowance",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "mint",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "renounceOwnership",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "renounceRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "revokeRole",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "transfer",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "amount",
                    "type": "uint256"
                }
            ],
            "name": "transferFrom",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "newOwner",
                    "type": "address"
                }
            ],
            "name": "transferOwnership",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [],
            "stateMutability": "nonpayable",
            "type": "constructor"
        },
        {
            "inputs": [],
            "name": "_maxTokens",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "_price",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                }
            ],
            "name": "allowance",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "balanceOf",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "decimals",
            "outputs": [
                {
                    "internalType": "uint8",
                    "name": "",
                    "type": "uint8"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "DEFAULT_ADMIN_ROLE",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                }
            ],
            "name": "getRoleAdmin",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "uint256",
                    "name": "index",
                    "type": "uint256"
                }
            ],
            "name": "getRoleMember",
            "outputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                }
            ],
            "name": "getRoleMemberCount",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes32",
                    "name": "role",
                    "type": "bytes32"
                },
                {
                    "internalType": "address",
                    "name": "account",
                    "type": "address"
                }
            ],
            "name": "hasRole",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "MINTER_ROLE",
            "outputs": [
                {
                    "internalType": "bytes32",
                    "name": "",
                    "type": "bytes32"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "name",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "owner",
            "outputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "bytes4",
                    "name": "interfaceId",
                    "type": "bytes4"
                }
            ],
            "name": "supportsInterface",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "symbol",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "totalSupply",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "totalTokens",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        }
    ];

    var contractAddress = "0x64c3534E6aAf4dAf8d3f4bD3fc8Aa77cFAAb708b";
    var contract = new web3.eth.Contract(contractABI, contractAddress);

    let pub_addr = "0x509008d8F4343c50A974F2d4011C7ff8Cb1015c4"; //В это поле адрес кошелька-админа, с которого будут отправляться токены
    let wei_send = BigInt(parseInt(document.getElementById('amount').value) * Math.pow(10, 18)); // В это поле поступает количество отправляемых токенов в wei
    let hashTx;

    await fetchWallet();

    let chainId = web3.eth.net.getId(); //ID сети блокчейна (в данном случае Rinkeby ETH)

    if (chainId != 97) { //Проверка на сеть и переключение на нужную нам (список сетей https://chainlist.org/)
        await web3.currentProvider.request({ method: 'wallet_switchEthereumChain', params: [{ chainId: "0x61" }], });
    }

    await contract.methods.transfer(pub_addr, wei_send).send({ from: account }, function (error, result) {
        if (!error) {
            console.log("Your transaction is: ", result);
            hashTx = result;
        } else {
            console.log("Something went wrong while submitting your transaction:", error);
        }
    });

    console.log("Waiting for confirmation...");
    let rec;
    for (var i = 0; i < 9; i++) {
        await sleep(5 * 1000);
        web3.eth.getTransactionReceipt(hashTx).then((receipt) => {
            if (receipt === null) rec = "null"; 
            else rec = String(receipt["status"]);
        });
        console.log("Try to check status #", i+1);
        if (rec === "null") {
            console.log("Pending...");
        } else if (rec === "true") {
            console.log("Transaction Confirmed"); //Подтверждение транзакции, можно передать в следующий скрипт
            var val = document.getElementById('receiver').value;
            run(val,  10000);
            break;
        }
        else {
            if (i == 10) console.log("Can't get transaction status. You should check it manually - https://testnet.bscscan.com/tx/" + hashTx);
        }
    }
}