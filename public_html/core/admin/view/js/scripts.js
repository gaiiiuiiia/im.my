document.querySelector('sitemap-button').onclick = (e) => {
    Ajax({type: 'POST'})
        .then((res) => {
            console.log('успех - ' + res);
        })
        .catch((res) => {
            console.log('ошибка - ' + res);
        });
}
