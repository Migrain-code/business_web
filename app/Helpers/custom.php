<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path)
{
    return env('IMAGE_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}

function authUser(){
    if (auth('official')->check()){
        return auth('official')->user();
    }
    /*else{

        return auth('admin')->user(); personel olacak
    }*/
}
function calculateTotal($services)
{
    $total=0;
    foreach ($services as $service){
        if ($service->service){
            $total+=$service->service->price;
        }
    }
    return $total;
}
function clearPhone($phoneNumber){
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);
    $newPhoneNumber = substr($newPhoneNumber, 1);
    return $newPhoneNumber;

}
function formatPhone($phone)
{
    return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone);
}
function createCheckbox($id,$model, $title , $additional_class = null) {
    return html()->div(
        html()->input()->class('form-check-input delete')->type('checkbox')
            ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
            ->attribute('data-title', $title)
            ->value($id),
        'form-check form-check-sm form-check-custom form-check-solid ' . $additional_class
    );
}
function createName($link, $text, $additional_class = null) {
    return html()->a($link, $text)->class('text-gray-800 text-hover-primary mb-1 ' . $additional_class);
}
function createPhone($link, $text, $additional_class = null) {
    return html()->a('tel:'.$link, "+90 ".$text)->class('text-gray-800 text-hover-primary mb-1 ' . $additional_class);
}
function create_show_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('bx bx-show'))->class('btn btn-info btn-sm me-1 ' . $additional_class);
}
function create_status_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('bx bx-check'))->class('btn btn-success btn-sm me-1 updatePaymentStatus' . $additional_class);
}
function create_send_button($route,$message = "", $additional_class = null)
{
    return html()->a('#'.$route, html()->i('')->class('bx bx-mail-send'))
        ->class('btn btn-warning btn-sm me-1 sendMail' . $additional_class)
        ->attribute('question', $message);
}
function create_edit_button($route, $additional_class = null)
{
    return html()->a($route, html()->i('')->class('fa fa-edit'))->class('btn btn-primary btn-sm me-1 ' . $additional_class);
}
function create_info_button($content = null)
{
    return html()->a('#', html()->i('')->class('fa fa-question-circle'))->class('btn btn-warning btn-sm me-1 ' . $additional_class);
}
function create_delete_button($model, $id, $title, $content, $route = '/isletme/ajax/delete/object')
{
    return html()->a('#', html()->i('')->class('fa fa-trash'))
        ->class('btn btn-danger btn-sm me-1 delete-btn')
        ->attribute('data-toggle', 'popover')
        ->attribute('data-object-id', $id)
        ->attribute('data-route', $route)
        ->attribute('data-model', 'App\Models\\' . str_replace('App\Models\\', '', $model))
        ->attribute('data-content', $content)
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


