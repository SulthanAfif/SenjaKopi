@extends('layouts.customer')
@section('content')


    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="space-y-5">
            <div class="rounded-3xl border border-stone-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
