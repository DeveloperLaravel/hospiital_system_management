<x-app-layout>
<div class="container">

<h3>Create Invoice 🧾</h3>

<form method="POST"
action="{{ route('invoices.store') }}">

@csrf


<select name="patient_id"
class="form-control mb-3">

@foreach($patients as $patient)

<option value="{{ $patient->id }}">
{{ $patient->name }}
</option>

@endforeach

</select>



<table class="table"
id="items">

<thead>

<tr>

<th>Name</th>
<th>Qty</th>
<th>Price</th>
<th></th>

</tr>

</thead>

<tbody>

<tr>

<td>

<input name="items[0][name]"
class="form-control">

</td>

<td>

<input name="items[0][quantity]"
type="number"
class="form-control">

</td>

<td>

<input name="items[0][price]"
type="number"
step="0.01"
class="form-control">

</td>

<td>

<button type="button"
onclick="addRow()"
class="btn btn-success">

+

</button>

</td>

</tr>

</tbody>

</table>


<button class="btn btn-primary">

Save

</button>


</form>

</div>



<script>

let i=1;

function addRow(){

let row=

`<tr>

<td>
<input name="items[${i}][name]"
class="form-control">
</td>

<td>
<input name="items[${i}][quantity]"
type="number"
class="form-control">
</td>

<td>
<input name="items[${i}][price]"
type="number"
class="form-control">
</td>

</tr>`;

document.querySelector('#items tbody')
.insertAdjacentHTML(
'beforeend',
row
);

i++;

}

</script>

</x-app-layout>
