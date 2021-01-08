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

createFile()

function createFile(){

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
                let attributeName = fileName.replace(/[\[\]]/g, '')

                for (let i in this.files){

                    if (this.files.hasOwnProperty(i)){

                        if (multiple){

                            if (typeof fileStore[fileName] === 'undefined')
                                fileStore[fileName] = []

                            // получили порядковый номер элемента в массиве, который мы только что добавили
                            let elemId = fileStore[fileName].push(this.files[i]) - 1

                            container[i].setAttribute(`data-deleteFileId-${attributeName}`, elemId)

                            showImage(this.files[i], container[i])

                            deleteNewFiles(elemId, fileName, attributeName, container[i])

                        }
                        else {

                            // в этот контейнер вставится изображение
                            container = this.closest('.img_container')
                                .querySelector('.img_show')

                            showImage(this.files[i], container)

                        }

                    }

                }

                //createEmptyBlocks()

            }

        })

        let form = document.querySelector('#main-form')

        if (form){

            form.onsubmit = function(e) {

                if (!isEmpty(fileStore)){

                    e.preventDefault()

                    // объект формы. даные в нем есть, просто в консоли не отображаются
                    let formData = new FormData(this)

                    console.log(formData);

                    for (let i in fileStore){

                        if (fileStore.hasOwnProperty(i)){

                            formData.delete(i)

                            let rowName = i.replace(/[\[\]]/g, '')

                            fileStore[i].forEach((item, index) => {

                                formData.append(`${rowName}[${index}]`, item)

                            })

                        }

                    }

                    formData.append('ajax', 'editData')

                }

            }

        }

        function createEmptyBlocks(elem){

            let gallery_containers = document.querySelectorAll('.gallery_container')

            console.log(gallery_containers);

            gallery_containers.forEach(container => {

                console.log(container);

                let empty = container.querySelector('.vg-dotted-square .vg-center').contains('.empty_container')

                console.log(empty);


            })

        }

        function deleteNewFiles(elemId, fileName, attributeName, container){

            container.addEventListener('click', function(){

                this.remove()
                delete fileStore[fileName][elemId]

                console.log(fileStore);

            })

        }

        function showImage(item, container){

            let reader = new FileReader()
            // очистка контейнера - вдруг перезагружаем файлик
            container.innerHTML = ''

            reader.readAsDataURL(item)

            reader.onload = e => {

                container.innerHTML = '<img class="img_item" src="">'

                container.querySelector('img').setAttribute('src', e.target.result)

                container.classList.remove('empty_container')

            }

        }

    }

}




