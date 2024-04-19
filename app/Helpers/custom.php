<?php

use Spatie\Html\Elements\A;
use Spatie\Html\Elements\Div;

function storage($path): string
{
    return asset('storage/' . $path);
}

function image($path)
{
    return env('IMAGE_URL') . $path;
}

function setting($key)
{
    return config('settings.' . $key);
}
function maskPhone($phone){
    $maskedPhone = substr_replace(clearPhone($phone), str_repeat('*', strlen($phone) - 2), 0, -2);
    return $maskedPhone;
}
function authUser()
{
    if (auth('official')->check()) {
        return auth('official')->user();
    }
    else{
        return auth('personel')->user();
    }
}

function calculateTotal($services)
{
    $total = 0;
    foreach ($services as $service) {
        if ($service->service) {
            $total += $service->service->price;
        }
    }
    return $total;
}

function clearPhone($phoneNumber)
{
    if (substr($phoneNumber, 1) != 0){
        $phoneNumber = "0".$phoneNumber;
    }
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);
    $newPhoneNumber = substr($newPhoneNumber, 1);
    return $newPhoneNumber;

}

function formatPhone($phone)
{
    return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone);
}

function createCheckbox($id, $model, $title, $additional_class = null, $isDelete = true)
{
    return html()->div(
        html()->input()->class('form-check-input delete')->type('checkbox')
            ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
            ->attribute('data-title', $title)
            ->attribute('data-delete', $isDelete)
            ->value($id),
        'form-check form-check-sm form-check-custom form-check-solid ' . $additional_class
    );
}

function createActionButton()
{
    $svgIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path></svg>';


    $span = Div::create()
        ->class('svg-icon svg-icon-5 m-0')
        ->text($svgIcon);

    $button = A::create()
        ->href('#')
        ->class('btn btn-sm btn-light btn-active-light-primary')
        ->attribute('data-kt-menu-trigger', 'click')
        ->attribute('data-kt-menu-placement', 'bottom-end')
        ->html($span)
        ->text('Actions');

    return $button;
}

function createName($link, $text, $additional_class = null)
{
    return html()->a($link, $text)->class('text-gray-800 text-hover-primary mb-1 ' . $additional_class);
}

function createPhone($link, $text, $additional_class = null)
{
    return html()->a('tel:' . $link, "+90 " . $text)->class('text-gray-800 text-hover-primary mb-1 ' . $additional_class);
}

function create_show_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('fa fa-eye'))->class('btn btn-info btn-sm me-1 ' . $additional_class);
}

function create_status_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('bx bx-check'))->class('btn btn-success btn-sm me-1 updatePaymentStatus' . $additional_class);
}

function create_send_button($route, $message = "", $additional_class = null)
{
    return html()->a('#' . $route, html()->i('')->class('bx bx-mail-send'))
        ->class('btn btn-warning btn-sm me-1 sendMail' . $additional_class)
        ->attribute('question', $message);
}

function create_edit_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('fa fa-edit'))->class('btn btn-primary btn-sm me-1 ' . $additional_class);
}
function create_swap_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('fa fa-arrows-turn-to-dots'))
        ->class('btn btn-warning btn-sm me-1 ' . $additional_class)
        ->data('bs-toggle', 'tooltip')
        ->attribute('title','İşletmenizin adı.');
}
function create_info_button($content = null, $additional_class = null)
{
    return html()->a('#', html()->i('')->class('fa fa-question-circle'))->class('btn btn-warning btn-sm me-1 ' . $additional_class);
}

function create_delete_button($model, $id, $title, $content, $isReload = "false", $route = '/isletme/ajax/delete/object', $deleteType = true)
{
    return html()->a('#', html()->i('')->class('fa fa-trash'))
        ->class('btn btn-danger btn-sm me-1 delete-btn')
        ->attribute('data-toggle', 'popover')
        ->attribute('data-object-id', $id)
        ->attribute('data-route', $route)
        ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
        ->attribute('data-content', $content)
        ->attribute('data-delete-type', $deleteType)
        ->attribute('data-reload', $isReload)
        ->attribute('data-title', $title);
}

function create_form_delete_button($model, $id, $title, $content)
{
    $svgIcon = collect([
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">',
        '<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="#bfbfbf" />',
        '<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />',
        '<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />',
        '</svg>',
    ])->implode('');

    return html()->a('#', html_entity_decode($svgIcon))
        ->class('btn btn-icon btn-active-light-primary w-30px h-30px me-3 delete-btn')
        ->attribute('data-bs-toggle', 'tooltip')
        ->attribute('title', 'Sil')
        ->attribute('data-object-id', $id)
        ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
        ->attribute('data-content', $content)
        ->attribute('data-title', $title);

}

function create_switch($id, $checked, $model, $colum = 'is_active'): \Spatie\Html\BaseElement|\Spatie\Html\Elements\Div
{
    $input = html()->input('checkbox', 'featured', $id)
        ->checked($checked)
        ->class('form-check-input ajax-switch')
        ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
        ->attribute('data-column', $colum);

    return html()->div($input)->class('form-check form-switch');
}

function formatPrice($price)
{
    return number_format($price, 2) . ' ₺';
}

function createButtonAndMenu()
{
    $dom = new DOMDocument();

    // Button
    $button = $dom->createElement('button');
    $button->setAttribute('type', 'button');
    $button->setAttribute('class', 'btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary me-n3');
    $button->setAttribute('data-kt-menu-trigger', 'click');
    $button->setAttribute('data-kt-menu-placement', 'bottom-end');

    // Svg Icon
    $svgIcon = $dom->createElement('span');
    $svgIcon->setAttribute('class', 'svg-icon svg-icon-3 svg-icon-primary');

    $svg = $dom->createElement('svg');
    $svg->setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    $svg->setAttribute('width', '24px');
    $svg->setAttribute('height', '24px');
    $svg->setAttribute('viewBox', '0 0 24 24');

    $g = $dom->createElement('g');
    $g->setAttribute('stroke', 'none');
    $g->setAttribute('stroke-width', '1');
    $g->setAttribute('fill', 'none');
    $g->setAttribute('fill-rule', 'evenodd');

    $rects = [
        ['5', '5', '5', '5', '1', 'currentColor'],
        ['14', '5', '5', '5', '0.3', 'currentColor'],
        ['5', '14', '5', '5', '0.3', 'currentColor'],
        ['14', '14', '5', '5', '0.3', 'currentColor']
    ];

    foreach ($rects as $rect) {
        $rectElement = $dom->createElement('rect');
        $rectElement->setAttribute('x', $rect[0]);
        $rectElement->setAttribute('y', $rect[1]);
        $rectElement->setAttribute('width', $rect[2]);
        $rectElement->setAttribute('height', $rect[3]);
        $rectElement->setAttribute('rx', $rect[4]);
        $rectElement->setAttribute('fill', $rect[5]);
        $g->appendChild($rectElement);
    }

    $svg->appendChild($g);
    $svgIcon->appendChild($svg);
    $button->appendChild($svgIcon);

    // Menu
    $menu = $dom->createElement('div');
    $menu->setAttribute('class', 'menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3');
    $menu->setAttribute('data-kt-menu', 'true');
    $menu->setAttribute('style', '');

    // Menu Heading
    $heading = $dom->createElement('div');
    $heading->setAttribute('class', 'menu-item px-3');
    $headingContent = $dom->createElement('div');
    $headingContent->setAttribute('class', 'menu-content text-muted pb-2 px-3 fs-7 text-uppercase');
    $headingContentText = $dom->createTextNode('Payments');
    $headingContent->appendChild($headingContentText);
    $heading->appendChild($headingContent);
    $menu->appendChild($heading);

    // Menu items
    $items = [
        ['Create Invoice', '#'],
        ['Create Payment', '#', 'fas fa-exclamation-circle ms-2 fs-7', 'Specify a target name for future usage and reference'],
        ['Generate Bill', '#'],
        ['Settings', '#']
    ];

    foreach ($items as $item) {
        $menuItem = $dom->createElement('div');
        $menuItem->setAttribute('class', 'menu-item px-3');
        $link = $dom->createElement('a');
        $link->setAttribute('href', $item[1]);
        $link->setAttribute('class', 'menu-link px-3');
        $linkText = $dom->createTextNode($item[0]);
        $link->appendChild($linkText);
        if (isset($item[2])) {
            $icon = $dom->createElement('i');
            $icon->setAttribute('class', $item[2]);
            $icon->setAttribute('data-bs-toggle', 'tooltip');
            $icon->setAttribute('aria-label', $item[3]);
            $icon->setAttribute('data-bs-original-title', $item[3]);
            $icon->setAttribute('data-kt-initialized', '1');
            $link->appendChild($icon);
        }
        $menuItem->appendChild($link);
        $menu->appendChild($menuItem);
    }

    // Append button and menu to the document
    $dom->appendChild($button);
    $dom->appendChild($menu);

    return $dom->saveHTML();
}
