<!-- ======= Contact Section ======= -->
<section id="contact" class="contact section-bg">
    <div class="container">

        <div class="section-title">
            <h2>Pré-registo</h2>
            <p>Será contactado para obtenção de toda a informação necessária para o pré-registo.</p>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
                <form action="/forms/contact" method="post" role="form" class="php-email-form" id="contact">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Nome de contacto">
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mt-3">
                            <input type="text" class="form-control" name="company_name" id="company_name"
                                placeholder="Nome da empresa">
                        </div>
                        <div class="col-md-6 form-group mt-3">
                            <input type="text" class="form-control" name="phone" id="phone"
                                placeholder="Telefone de contacto">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5"
                            placeholder="Informação adicional"></textarea>
                    </div>
                    <div class="text-center"><button type="submit">Enviar</button></div>
                </form>
            </div>

        </div>

        <div class="row mt-5 justify-content-center">

            <div class="col-lg-10">

                <div class="info-wrap">
                    <div class="row">
                        <div class="col-lg-4 info">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Localização:</h4>
                            <p>
                                Rua da Liberdade, Nº 135 R/C<br>
                                3700-169 São João da Madeira<br>
                                Portugal</p>
                        </div>

                        <div class="col-lg-4 info mt-4 mt-lg-0">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>info@comerciodacidade.pt</p>
                        </div>

                        <div class="col-lg-4 info mt-4 mt-lg-0">
                            <i class="bi bi-phone"></i>
                            <h4>Contacto:</h4>
                            <p>+351 910 898 931<br>
                                (Chamada para rede movel nacional)</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section><!-- End Contact Section -->