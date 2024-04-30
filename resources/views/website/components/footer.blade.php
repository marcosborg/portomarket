<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <img src="/theme/assets/img/logo2.png" width="200" class="mb-4">
                    <p>
                        Rua Chaves de Oliveira<br>
                        4350-104 Porto<br>
                        Portugal <br><br>
                        <strong>Telefone:</strong> +351 912 341 906<br>
                        (Chamada para rede movel nacional)<br>
                        <strong>Email:</strong> info@porto.market<br>
                    </p>
                </div>

                <div class="col-lg-5 col-md-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ Route::currentRouteName('homepage') ? '' : '/' }}#hero">Início</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ Route::currentRouteName('homepage') ? '' : '/' }}#about">Sobre</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ Route::currentRouteName('homepage') ? '' : '/' }}#services">Serviços</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ Route::currentRouteName('homepage') ? '' : '/' }}#contact">Contactos</a></li>
                        @foreach ($pages as $page)
                        <li><i class="bx bx-chevron-right"></i> <a data-bs-toggle="modal" data-bs-target="#{{ Illuminate\Support\Str::slug($page->title) }}"
                                href="#">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Receba a nossa Newsletter</h4>
                    <p>Enviaremos atualizações oportunas.</p>
                    <form action="/forms/newsletter" method="post" id="newsletter">
                        @csrf
                        <input type="email" name="email">
                        <input type="submit" value="Subscrever">
                    </form>
                    <a href="https://www.livroreclamacoes.pt/Inicio/" target="_new" class="mt-4 d-block">
                        <img src="/theme/assets/img/i006572.png" class="img-fluid">
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
            <div class="copyright">
                &copy; Copyright <strong><span>Porto Market</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="https://netlook.pt/">Netlook</a>
            </div>
        </div>
    </div>
</footer><!-- End Footer -->