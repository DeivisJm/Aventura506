@extends('admin.layouts.admin')

@section('admin-content')

<form method="POST"
    action="{{ route('admin.tours.update', $tour) }}"
    enctype="multipart/form-data"
    class="space-y-16">

    @csrf
    @method('PUT')

    {{-- ========================================================= --}}
    {{-- GENERAL INFORMATION --}}
    {{-- ========================================================= --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow space-y-6">

        <h2 class="text-xl font-bold text-green-600">
            General Information
        </h2>

        {{-- Name --}}
        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <label class="font-semibold">Name (Spanish)</label>
                <input type="text"
                    name="name[es]"
                    required
                    value="{{ $tour->name['es'] ?? '' }}"
                    class="input-admin">
            </div>

            <div>
                <label class="font-semibold">Name (English)</label>
                <input type="text"
                    name="name[en]"
                    required
                    value="{{ $tour->name['en'] ?? '' }}"
                    class="input-admin">
            </div>

        </div>

        {{-- Slug --}}
        <div>
            <label class="font-semibold">Slug</label>
            <input type="text"
                name="slug"
                required
                value="{{ $tour->slug }}"
                class="input-admin">
        </div>

        {{-- Image --}}
        <div>
            <label class="font-semibold">Image</label>
            <input type="file" name="image" class="input-admin">

            @if($tour->image)
            <img src="{{ asset($tour->image) }}"
                class="h-40 mt-4 rounded-xl">
            @endif
        </div>

        {{-- Category --}}
        <div>
            <label class="font-semibold">Category</label>
            <select name="category_id" required class="input-admin">
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $tour->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Company --}}
        <div>
            <label class="font-semibold">Company</label>
            <select name="company_id" required class="input-admin">
                @foreach($companies as $company)
                <option value="{{ $company->id }}"
                    {{ $tour->company_id == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
                @endforeach
            </select>
        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- TOUR DETAIL --}}
    {{-- ========================================================= --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow space-y-6">

        <h2 class="text-xl font-bold text-green-600">
            Tour Detail
        </h2>

        {{-- Duration --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label>Duration (ES)</label>
                <input type="text"
                    name="detail[duration][es]"
                    required
                    value="{{ $tour->detail->duration['es'] ?? '' }}"
                    class="input-admin">
            </div>

            <div>
                <label>Duration (EN)</label>
                <input type="text"
                    name="detail[duration][en]"
                    required
                    value="{{ $tour->detail->duration['en'] ?? '' }}"
                    class="input-admin">
            </div>
        </div>

        {{-- Full Description --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label>Full Description (ES)</label>
                <textarea name="detail[full_description][es]"
                    required
                    class="input-admin h-40">{{ $tour->detail->full_description['es'] ?? '' }}</textarea>
            </div>

            <div>
                <label>Full Description (EN)</label>
                <textarea name="detail[full_description][en]"
                    required
                    class="input-admin h-40">{{ $tour->detail->full_description['en'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- Location --}}
        <div>
            <label>Location Name</label>
            <input type="text"
                name="detail[location_name]"
                required
                value="{{ $tour->detail->location_name ?? '' }}"
                class="input-admin">
        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- PRICES --}}
    {{-- ========================================================= --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow space-y-6">

        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-green-600">Prices</h2>
            <button type="button" onclick="addPrice()" class="btn-primary px-4 py-2 text-sm">
                + Add Price
            </button>
        </div>

        <div id="prices-container">

            @foreach($tour->prices as $index => $price)
            <div class="border p-6 rounded-xl space-y-4 price-block">

                <input type="hidden" name="prices[{{ $index }}][id]" value="{{ $price->id }}">

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label>Type (ES)</label>
                        <input type="text"
                            name="prices[{{ $index }}][type][es]"
                            required
                            value="{{ $price->type['es'] ?? '' }}"
                            class="input-admin">
                    </div>

                    <div>
                        <label>Type (EN)</label>
                        <input type="text"
                            name="prices[{{ $index }}][type][en]"
                            required
                            value="{{ $price->type['en'] ?? '' }}"
                            class="input-admin">
                    </div>

                </div>

                <div>
                    <label>Price (USD)</label>
                    <input type="number"
                        step="0.01"
                        name="prices[{{ $index }}][price]"
                        required
                        value="{{ $price->price }}"
                        class="input-admin">
                </div>

                <button type="button"
                    onclick="this.closest('.price-block').remove()"
                    class="text-red-500 text-sm">
                    Remove
                </button>

            </div>
            @endforeach

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- SCHEDULES --}}
    {{-- ========================================================= --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow space-y-6">

        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-green-600">Schedules</h2>
            <button type="button" onclick="addSchedule()" class="btn-primary px-4 py-2 text-sm">
                + Add Schedule
            </button>
        </div>

        <div id="schedules-container">

            @foreach($tour->schedules as $index => $schedule)
            <div class="flex gap-4 items-center schedule-block">

                <input type="hidden"
                    name="schedules[{{ $index }}][id]"
                    value="{{ $schedule->id }}">

                <input type="time"
                    name="schedules[{{ $index }}][start_time]"
                    required
                    value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                    class="input-admin">

                <button type="button"
                    onclick="this.closest('.schedule-block').remove()"
                    class="text-red-500 text-sm">
                    Remove
                </button>

            </div>
            @endforeach

        </div>

    </div>

    {{-- Submit --}}
    <div class="text-right">
        <button type="submit" class="btn-primary px-8 py-3 text-lg">
            Update Tour
        </button>
    </div>

</form>


@endsection