<section class="home-hero">
    <div class="container">
        <div class="row justfiy-content-center align-items-center">
            <div class="col-lg-6">
                <div class="text-content" data-aos="zoom-in">
                    <h2>

                  <span id="hairdresserArea">
                    <label id="hairdresserLabel">Kuaför
                      <img
                          class="shape-2"
                          src="/front/assets/images/business/shape-2.svg"
                          alt="" /></label></span>
                        <span><strong>Salon</strong> Yönetim Programı</span>

                        <p>
                            Randevu alma sürecinden satışa geçmek, Hızlı Randevu ile işletmenizi kolayca yönetebilmeniz demektir. Zamanınızı verimli kullanarak işinizi büyütün.<br />
                            için basit bir çözüm.
                        </p>
                    </h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-form" data-aos="zoom-in">
                    <div class="hero">
                        <h3>Sizi arayalım</h3>
                        <p>
                            Sistem hakkında bilgi almak için <br />
                            aşağıdaki formu doldurun sizi arayalım.
                        </p>
                    </div>
                    <form action="{{route('send.informationRequest')}}" method="post">
                        @csrf
                        <div class="field">
                            <input type="text" name="name" placeholder="İşletme Sahibi"/>
                        </div>

                        <div class="field">
                            <input type="text" name="salon_name" placeholder="İşletme Adı"/>
                        </div>

                        <div class="field">
                            <input type="text" name="phone" placeholder="Telefon Numaranız"/>
                        </div>

                        <div class="field">
                            <button type="submit">Bilgi Al</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
