const key = 'thKvmptJD4p2zeCeRBUYcb52smyUJRcn';
const secret = 'tQWAUAVEL77TChQnSyU7AzP4ysBvvmfr';

/**
 * Функция генерирующая подпись запроса
 * Алгоритм генерации:
 * - объект запроса кананизируется (по факту объяект сортируется по полям)
 * - формируется строка запроса в формате uri
 * - с использованием алгоритма hmac sha256 генерируется подпись с указанным ключем secret
 * - подпсь добавляется в запрос при отправке
 * @param data объект для подписи
 * @param secret секрет для хэширования
 * @param addTs добавлять ли автоматически текущий таймстемп к зарпосу
 * @param addSign автоматически добавлять подпись в запрос
 * @return {string|object} если addSign == true - возвращает заперос с подписью, если false - только подпись строкой
 */
function signRequest(data, secret, addTs = true, addSign = true) {
    if (addTs) {
        data.ts = (new Date()).getTime();
    }
    const payload = Object.keys(data)
        .sort()
        .reduce((accumulator, key) => {
            accumulator.push(key + '=' + encodeURIComponent(data[key]));

            return accumulator;
        }, []).join('&');


        const sign = CryptoJS.HmacSHA256(payload, secret).toString();

    if (addSign) {
        data.sign = sign;
        return data;
    }

    return sign
}


// Все запросы к API должны быть подписаны. Алгоритм подписи есть в функции getSign
// Все запросы должны включать параметры key - ключ APi и ts - текущее время в unix timestamp
// Доступные запросы
// 1. Список текущих подписок на переводы (адрес и url куда стучать)
// - запрос только со общими параметрами
// Ответ - массив со всеми подписками
axios.post('https://v1.artery-services.com/api/v1/wallet/subscriptions',
    signRequest({key}, secret))
    .then(result => result.data)
    .then(console.log)
    .catch((r) => {
        console.log(r.response.data)
    });

// 2. Подписаться на транзакции перевода по кошельку
// - address - адрес кошелька в bech32
// - url - URL куда сообщать о переводах
// Ответ - объект с информацией о подписке
axios.post('https://v1.artery-services.com/api/v1/wallet/subscriptions/add',
    signRequest({
        key,
        address: 'artr1yjw550d4fua8yggd4dr65f2eh5a0t2sw22tsp2',
        url: 'https://artery.network/'
    }, secret))
    .then(result => result.data)
    .then(console.log)
    .catch((r) => {
        console.log(r.response.data)
    });

// 3. Отписаться от транзакции перевода по кошельку
// - address - адрес кошелька в bech32
// - url - URL куда сообщать о переводах
// Ответ - result и код ошибки. 0 - успешно
axios.post('https://v1.artery-services.com/api/v1/wallet/subscriptions/remove',
    signRequest({
        key,
        address: 'artr1yjw550d4fua8yggd4dr65f2eh5a0t2sw22tsp2',
        url: 'https://artery.network/'
    }, secret))
    .then(result => result.data)
    .then(console.log)
    .catch((r) => {
        console.log(r.response.data)
    });