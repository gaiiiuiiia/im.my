
<div class="container">

    <?php foreach ($this->goodsByCategory as $category => $goods): ?>

        <section class="goods-cards">

            <a id="<?=$category?>"></a>

            <h2 class="ct-name"><?=$category?></h2>
            <div class="col-lg-12 d-flex justify-content-center card-wrapper">
                <div class="col-lg-10 d-flex justify-content-center">
                    <div class="row justify-content-around">

                        <?php foreach ($goods as $item): ?>
                            <div class="card" style="width: 18rem;">

                                <div class="img-wrapper">
                                    <?php if ($item['img']) :?>
                                        <img class="img-wrapper" src="<?=PATH . UPLOAD_DIR . $item['img']?>" alt="service">
                                    <?php endif;?>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?=$item['name']?></h5>
                                    <hr>
                                    <p class="card-text"><?=$item['description']?></p>
                                </div>

                                <div class="card-footer">
                                    <a href="#" class="btn btn-primary">В корзину</a>
                                    <h6><?=$item['count'] > 5 ? "Есть в наличии" : "Спешите! Осталось: {$item['amount']}"?></h6>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        </section>

    <?php endforeach; ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../../index.php" alt="Первый слайд">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../index.php" alt="Второй слайд">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../index.php" alt="Третий слайд">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>



