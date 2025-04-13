@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12" style='padding-bottom: 20px;'>
            <x-card>
                <x-slot name="header" class="bg-white border-bottom-0">
                    <h5 class="card-title mt-3 mb-3">Dashboard</h5>
                    <h6></h6>
                </x-slot>

                <div class="row">
                </div>
            </x-card>
        </div>

        </div>
    </div>
@endsection
