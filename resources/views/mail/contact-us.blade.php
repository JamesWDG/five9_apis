<H1>Contact Form</H1>
Name : {{ $name ?? '' }} <br>

@if ($message)
    Message : {{ $message ?? '' }}<br>
@endif
@if ($company_name)
    Company Name : {{ $company_name ?? '' }}<br>
@endif

@if ($phone)
    Phone : {{ $phone ?? '' }}<br>
@endif
