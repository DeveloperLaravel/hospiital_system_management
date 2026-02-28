<x-app-layout>

<div class="container">

<div class="card">

<div class="card-header">

Invoice

{{ $invoice->invoice_number }}

</div>


<div class="card-body">

<h5>

Patient:
{{ $invoice->patient->name }}

</h5>


<h5>

Total:
${{ $invoice->total }}

</h5>


<h5>

Status:
{!! $invoice->status_badge !!}

</h5>


<h5>

Date:
{{ $invoice->invoice_date }}

</h5>


<button onclick="window.print()"
class="btn btn-primary">

Print 🖨

</button>

</div>

</div>

</div>
</x-app-layout>