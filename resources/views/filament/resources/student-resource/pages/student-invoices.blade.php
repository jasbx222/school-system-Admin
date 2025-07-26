<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<x-filament-panels::page>
    @if (sizeOf($this->getRecord()->invoices) != 0)
        <div style="display: inline-flex">
            <a href="{{ route('invoices-export-excel', ['id' => $this->getRecord()->id]) }}" class="btn-export-excel"
                style="    margin-left: 15px;"><svg style="width: 25px;display: inline;" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                </svg>Excel
            </a>
            <a href="{{ route('invoices-export-pdf', ['id' => $this->getRecord()->id]) }}" class="btn-export-pdf"><svg
                    style="width: 25px;display: inline;" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                </svg>Pdf
            </a>
        </div>
    @endIf
    <div class="container mt-6 mb-7">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-7">
                <div class="card">
                    @if (sizeOf($this->getRecord()->invoices) == 0)
                        <div class="card-body p-5">
                            <h2 style="color: red; margin-bottom:10px"> لم يتم تسديد أي فاتورة حتى الان</h2>
                        </div>
                    @else
                        <div class="card-body p-5">
                            <table class="table border-bottom border-gray-200 mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">
                                            تاربخ الدفع</th>
                                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">
                                            المبلغ</th>
                                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">رقم الوصل
                                        </th>
                                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0"> #
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->getRecord()->invoices as $key => $invoice)
                                        <tr>
                                            <td class="px-0">{{ $invoice->created_at }}</td>
                                            <td class="px-0">{{ $invoice->value }}</td>
                                            <td class="px-0">{{ $invoice->number }}</td>
                                            <td class="px-0">{{ $key + 1 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-5">
                                <div class="column">
                                    <h3>قيمة القسط</h3>
                                    <h5>{{ $this->getRecord()->cost_of_semester_after_offer }}</h5>
                                </div>
                                <div class="column">
                                    <p>مجموع الفواتير</p>
                                    <span>{{ $this->getRecord()->sum_of_invoices }}</span>
                                </div>
                                <div class="column">
                                    <p>المتبقي من القسط</p>
                                    <span>{{ $this->getRecord()->rest_of_invoices }}</span>
                                </div>
                            </div>
                        </div>
                    @endIf
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
