<style>
    @font-face {
        font-family: Amiri-Bold;
        src: url('/fonts/Amiri-Bold.tff') format('truetype');
        /* font-weight: bold; */
        font-style: normal;
    }

    body {
        margin-top: 20px;
        font-family: DejaVu Sans, serif;
        direction: rtl
    }

    .card-footer-btn {
        display: flex;
        align-items: center;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .justify-content-center {
        justify-content: center !important;
    }

    .justify-content-center {
        justify-content: right !important;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #18181B;
        background-clip: border-box;
        border: 1px solid rgba(30, 46, 80, .09);
        border-radius: 0.25rem;
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    }

    .card-pdf {
        background-color: #eeeeee;
    }

    .p-5 {
        padding: 3rem !important;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.5rem 1.5rem;
    }

    table {
        width: 100%;
        direction: ltr;
        text-align: center;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: inherit;
        border-style: solid;
        border-width: 0;
    }

    .table td,
    .table th {
        border-bottom: 1px solid #edf2f9;
    }

    .table>:not(caption)>*>* {
        padding: 1rem 1rem;
        background-color: var(--bs-table-bg);
        border-bottom-width: 1px;
        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    }

    .px-0 {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    .table thead th,
    tbody td,
    tbody th {
        vertical-align: middle;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: inherit;
        border-style: solid;
        border-width: 0;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }

    .d-flex {
        display: flex;
    }

    .row {
        display: flex;
        flex-direction: column;
        /* gap: 10px; */
    }

    .column {
        display: flex;
    }

    .column h3 {}

    .btn-export {
        width: 100px;
        background-color: #04AA6D;
        border: none;
        color: white;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
    }
</style>
<div class="container mt-6 mb-7">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-7">
            <div class="card card-pdf">
                <div class="card-body p-5">
                    {{-- <h2 style="text-align: center;"> {{ $student }}</h2> --}}
                    <table class="table border-bottom border-gray-200 mt-3">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-sm   text-end px-0">
                                    تاربخ الدفع</th>
                                <th scope="col" class="fs-sm   text-end px-0">
                                    المبلغ</th>
                                <th scope="col" class="fs-sm   px-0">رقم الوصل
                                </th>
                                <th scope="col" class="fs-sm   text-end px-0">
                                    #</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                                <tr>
                                    <td class="text-end px-0">{{ $invoice->created_at }}</td>
                                    <td class="text-end px-0">{{ $invoice->value }}</td>
                                    <td class="px-0">{{ $invoice->number }}</td>
                                    <td class="px-0">{{ $key + 1 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
