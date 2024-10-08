<div id="context-menu">
    <div class="header">Hızlı İşlemler</div>

    <a href="{{ route('business.appointment.index') }}" id="create-appointment">
        <i class="fa fa-calendar-plus"></i> Randevu Oluştur <span class="shortcut">Ctrl+R</span>
    </a>
    <a href="{{ route('business.appointment.index') }}" id="create-appointment">
        <i class="fa fa-calendar-plus"></i> Saat Kapat <span class="shortcut">Ctrl+R</span>
    </a>
    <a href="{{ route('business.adission.index') }}" id="create-bill">
        <i class="fa fa-receipt"></i> Adisyon Oluştur <span class="shortcut">Ctrl+A</span>
    </a>

    <a href="{{ route('business.service.index') }}" id="create-service">
        <i class="fa fa-receipt"></i> Hizmet Oluştur <span class="shortcut">Ctrl+A</span>
    </a>
    <a href="{{ route('business.personel.create') }}" id="create-personel">
        <i class="fa fa-receipt"></i> Personel Oluştur
        <span class="shortcut">Ctrl+A</span>
    </a>
    <a href="{{ route('business.sale.create') }}" id="create-sale">
        <i class="fa fa-receipt"></i> Ürün Satışı Yap
        <span class="shortcut">Ctrl+A</span>
    </a>
    <a href="{{ route('business.package-sale.index') }}" id="create-package-sale">
        <i class="fa fa-receipt"></i> Paket Satışı Yap
        <span class="shortcut">Ctrl+A</span>
    </a>
    <a href="{{env('REMOTE_URL').authUser()->business->slug}}" target="_parent" id="go-salon">
        <i class="fa fa-globe"></i> Salona Git <span class="shortcut">Ctrl+G</span>
    </a>
</div>
