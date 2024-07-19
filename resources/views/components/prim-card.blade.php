<tr class="fw-bold text-gray-700 fs-5 text-end border-bottom border-dashed">
    <td class="d-flex align-items-center pt-11">
        <i class="fa fa-genderless text-{{$icon}} fs-1 me-2"></i>{{$title}}</td>
    <td class="pt-11">{{ $subTitle == "%0" ? "Maaşlı": $subTitle}}</td>
    <td class="pt-11">{{ $price1 }}</td>
    <td class="pt-11 fs-5 pe-lg-6 text-dark fw-bolder">{{ $price2 }}</td>
</tr>
