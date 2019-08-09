<?php
    require 'req/validaSessao.php';
    
    try {
        require 'req/conexao.php';

        $consulta = $conexao->query("SELECT * FROM noticias");

        $noticias = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $ultimasNoticias = array_slice(array_reverse($noticias), 0, 3);

        $conexao = null;
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }

    include 'layouts/head.php';
    include 'layouts/header.php';
  ?>

<!--================ Hero sm Banner start =================-->
<section class="mb-30px">
  <div class="container">
    <div class="hero-banner hero-banner--sm">
      <div class="hero-banner__content">
        <h1>Bem vindo ao Blog</h1>
      </div>
    </div>
  </div>
</section>
<!--================ Hero sm Banner end =================-->

<!--================ Start Blog Post Area =================-->
<section class="blog-post-area section-margin">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <?php foreach($noticias as $noticia) : ?>
            <div class="col-md-6">
              <div class="single-recent-blog-post card-view">
                <div class="thumb">
                  <img
                    class="card-img rounded-0"
                    src="<?= $noticia["url_imagem"]?>"
                    alt="Foto de capa"
                  />
                  <ul class="thumb-info">
                    <li>
                      <a href="#"><i class="ti-user"></i>Admin</a>
                    </li>
                    <li>
                      <a href="#"><i class="fas fa-calendar"></i><?= $noticia["data_criacao"] ?></a>
                    </li>
                  </ul>
                </div>
                <div class="details mt-20">
                  <a href="blog-single.html">
                    <h3>
                      <?= $noticia["titulo"] ?>
                    </h3>
                  </a>
                  <p>
                    <?= substr($noticia["descricao"], 0, 40); ?>
                  </p>
                  <a class="button" href="detalhes.php?id=<?= $noticia["id"] ?>"
                    >Ler Mais <i class="ti-arrow-right"></i
                  ></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Start Blog Post Siddebar -->
      <div class="col-lg-4 sidebar-widgets">
        <div class="widget-wrap">
          <div class="single-sidebar-widget popular-post-widget">
            <h4 class="single-sidebar-widget__title">Popular Post</h4>
            <div class="popular-post-list">
               <?php foreach($ultimasNoticias as $noticia) : ?>
                <div class="single-post-list">
                  <div class="thumb">
                    <img
                      class="card-img rounded-0"
                      src="<?= $noticia["url_imagem"]?>"
                      alt="Foto de capa"
                    />
                    <ul class="thumb-info">
                      <li><a href="#">Admin</a></li>
                      <li><a href="#"><?= $noticia["data_criacao"] ?></a></li>
                    </ul>
                  </div>
                  <div class="details mt-20">
                    <a href="blog-single.html">
                      <h6>
                        <?= $noticia["titulo"] ?>
                      </h6>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Blog Post Siddebar -->
  </div>
</section>

<?php include 'layouts/footer.php' ?>
