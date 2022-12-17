@extends('layouts.admin')
@section('content')
<div class="w-full h-full flex justify-center content-center py-20 flex-col">
    <h1 class="text-center text-white">Signup</h1>
    <div class="flex justify-center content-start item-start">
        <div class="mt-5 md:col-span-2 md:mt-0">
            {!! Form::open([ 'method' => 'POST']) !!}
            <div class="shadow sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            {{ Form::label('username', 'Username', ['class' => 'block text-sm font-medium
                            text-gray-700']) }}
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">@</span>
                                {{ Form::email('text', '', ['class' => 'block w-full flex-1 rounded-none rounded-r-md
                                border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder'
                                => 'Username']) }}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            {{ Form::label('password', 'password', ['class' => 'block text-sm font-medium
                            text-gray-700']) }}
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">@</span>
                                {{ Form::email('password', '', ['class' => 'block w-full flex-1 rounded-none
                                rounded-r-md border-gray-300
                                focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm', 'placeholder' => 'passowrd'])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                    {{ Form::submit('Submit', ['class' => 'inline-flex justify-center rounded-md border
                    border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm
                    hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']) }}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>