document.querySelector('.sitemap-button').onclick = (e) => {

    e.preventDefault();

    createSitemap();

}

let links_counter = 0;

function createSitemap(){

    links_counter++;

    Ajax({data: {ajax:'sitemap', links_counter: links_counter}})
        .then((res) => {
            console.log('успех - ' + res);
        })
        .catch((res) => {
            console.log('ошибка - ' + res);
        });
}

let files = document.querySelectorAll('input[type=file]')
let fileStore = [];


if (files.length){

    files.forEach(item => {

        item.onchange = function() {

            let multiple = false
            let parentContainer
            let container

            if (item.hasAttribute('multiple')){

                multiple = true

                parentContainer = this.closest('.gallery_container')

                if (!parentContainer)
                    return false

                container = parentContainer.querySelectorAll('.empty_container')

                let container_length = container.length
                let files_length = this.files.length

                if (container_length < files_length){

                    for (let index = 0; index < files_length - container_length; index++){

                        let el = document.createElement('div')
                        el.classList.add('vg-dotted-square', 'vg-center', 'empty_container')

                        parentContainer.append(el)

                    }

                }

                container = parentContainer.querySelectorAll('.empty_container')

            }

            // название объекта загрузки изображения
            let fileName = item.name
            let attributeName = item.name.replace(/[\[\]]g/, '')

            for (let i in this.files){

                if (this.files.hasOwnProperty(i)){

                    if (multiple){



                    }
                    else {

                        // в этот контейнер вставится изображение
                        container = this.closest('.img_container')
                            .querySelector('.img_show')

                        showImage(this.files[i], container)

                    }

                }

            }

        }

    })

    function showImage(item, container){

        let reader = new FileReader()
        // очистка контейнера - вдруг перезагружаем файлик
        container.innerHTML = ''

        reader.readAsDataURL(item)

        reader.onload = e => {

            container.innerHTML = '<img class="img_item" src="">'

            container.querySelector('img').setAttribute('src', e.target.result)


        }

    }

}


