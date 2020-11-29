
Ajax({type: 'POST'})
    .then((res) => {
        console.log('успех - ' + res);
    })
    .catch((res) => {
        console.log('ошибка - ' + res);
    });