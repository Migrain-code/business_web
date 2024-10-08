<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_overview" role="tabpanel">

    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0 d-flex align-items-center">
            <div class="card-title">
                <h3 class="fw-bolder me-4">Yetkileri</h3>
                <select name="permissionIdSelect" id="permissionIdSelect" aria-label="Yetki Adı Giriniz" data-control="select2" data-placeholder="Yetki Adı Giriniz..."
                        data-dropdown-parent="#kt_ecommerce_customer_overview"
                        class="form-select form-select-solid fw-bold min-w-300px">
                    <option value="">Yetki Adı Giriniz</option>
                    @foreach($permissionGroups as $group)
                        @if($admin->hasAnyPermission($group->permissions))
                        <option value="{{$group->id}}">{{$group->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <button class="btn btn-success" type="button" onclick="$('#updatePermissionForm').submit()">Yetkileri Güncelle</button>
                <button class="btn btn-primary" type="button" id="serviceAllSelect">Tümünü Seç</button>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <form class="card-body pt-0 pb-5" id="updatePermissionForm" method="post" action="{{route('business.official.permission.update', $official->id)}}">
            <!--begin::Table-->
            @csrf
            @forelse($permissionGroups as $group)
                @if($admin->hasAnyPermission($group->permissions))
                <div class="card mb-7" id="permissionGroup{{$group->id}}" style="box-shadow: 1px 3px 15px #d9d3d3a8;">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">
                            {{$group->name}}
                        </h3>
                        <div class="form-check form-switch">
                            <input class="form-check-input categorySwitch categoryCheckBox-{{$group->id}}" type="checkbox" data-category-id="{{$group->id}}" data-target="category-{{$group->id}}">
                        </div>
                    </div>
                    <div class="card-body" style="padding-top: 0px !important;">
                        <table class="table align-middle table-row-dashed gy-5">
                            @foreach($group->permissions as $permission)
                                @if($admin->hasPermissionTo($permission))
                                <tr>
                                    <td>{{$permission->title}}</td>
                                    <td>
                                        @if($official->hasPermissionTo($permission))
                                            <span class="badge badge-success">İzin verildi</span>
                                        @else
                                            <span class="badge badge-danger">İzin verilmedi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input serviceChecks productSwitch category-{{$permission->group_id}}" data-category="categoryCheckBox-{{$permission->group_id}}"
                                                   name="permissions[]" type="checkbox"  @checked($official->hasPermissionTo($permission))
                                                   value="{{$permission->id}}">
                                        </div>
                                    </td>


                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-success " type="button" onclick="$('#updatePermissionForm').submit()">Yetkileri Güncelle</button>

                    </div>
                </div>
                @endif
            @empty
                @include('business.layouts.components.alerts.empty-alert')
            @endforelse

            <!--end::Table-->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary min-w-250"> Yetkileri Güncelle </button>
            </div>
        </form>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end:::Tab pane-->
