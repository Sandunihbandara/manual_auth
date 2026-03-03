@extends('layouts.app')

@section('title', 'Help & Support - AcademiCore')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

    <h1 class="text-3xl font-bold">Help & Support</h1>

    {{-- FAQ Section --}}
    <div class="bg-black/40 border border-white/10 rounded-2xl p-6">
        <h2 class="text-xl font-semibold mb-4">Frequently Asked Questions</h2>

        <div class="space-y-4 text-white/80">

            <div>
                <div class="font-semibold text-white">How do I book an instrument?</div>
                <div class="text-sm mt-1">
                    Go to Instruments → Select instrument → Choose date & time → Submit request.
                </div>
            </div>

            <div>
                <div class="font-semibold text-white">Why is my booking pending?</div>
                <div class="text-sm mt-1">
                    Staff or Admin must approve your booking before it becomes active.
                </div>
            </div>

            <div>
                <div class="font-semibold text-white">Why can't I select past dates?</div>
                <div class="text-sm mt-1">
                    System only allows booking from current time onward.
                </div>
            </div>

        </div>
    </div>

    {{-- Contact Section --}}
    <div class="bg-black/40 border border-white/10 rounded-2xl p-6">
        <h2 class="text-xl font-semibold mb-4">Contact Support</h2>

        <div class="text-white/80 text-sm space-y-2">
            <div>Email: support@cmb.ac.lk</div>
            <div>Office: Instrument Lab Office</div>
            <div>Phone: +94 11 2345678</div>
        </div>
    </div>

</div>

@endsection