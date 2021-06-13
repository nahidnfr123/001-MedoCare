@extends('layouts.app_front')

@section('title')
    @php $title = 'About'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

    <!-- Body content -->
    <div id="MainContent">

        <!-- Banner image -->
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="{{ config('app.image_url', null) }}/storage/image/web_layout/banner/ab_us.jpg" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }} </h1>
        </div>


        <section class="Section_Container About_Section wow fadeInUp">
            <div class="About_Text container col-12 col-md-12 col-lg-10">

                <div class="bg-gray p-l-20 p-b-20 p-t-20" style="position: relative; z-index: 2;">
                    <h1 class="text-center"> About us. </h1>
                    <img data-src="{{('/storage/image/web_layout/about/img_1.png')}}" alt="" class="float-right about_image_1">

                    <p class="about_text">
                        Many people around the world die due to the lack of transfusion of blood. However,
                        blood transfusion saves life, but transfusion of unsafe blood puts lives at risk
                        because of disease like HIV, Hepatitis B, malaria etc. Nowadays it is difficult to
                        find good doctors and booking appointments is another hassle. Sometimes it is difficult
                        to find doctor in emergency cases and appointments are also limited or not available.
                        The proposed project that is to be developed is an online medical service named
                        MedoCare. This project includes 24/7 live online doctor consultation, doctor
                        appointment booking, blood donation, patient management, blood bank management
                        etc. The main motive of this project is to connect patients to available doctor
                        for online consultation and create a link between patient, blood donor and blood
                        banks. This would enable patients to find blood at ease and ensure safe blood is
                        available for all the patient who needs it.
                    </p>
                </div>
                <br>
                <div class="bg-dark p-l-20 p-b-20 p-t-20 p-r-20 color-white">
                    <h1 class="text-center">We care about you.</h1>

                    <img data-src="{{('/storage/image/web_layout/about/img_2.png')}}" alt="" class="float-left about_image_2">
                    <p class="about_text_2">
                        The system will prove to be helpful in urgent cases that fail to reach hospital,
                        during late night or for emergency cases that do not have doctors in the area and
                        when people cannot find enough time to visit to the doctor. Doctors form foreign
                        countries can also join and provide online consultation services to patient. Lots
                        of money will be saved from travelling to other countries to visit the doctor and
                        therefore patients are able to get batter treatment at low cost. Patients must pay
                        for online consultation with a doctor. Online doctor appointment booking can reduce
                        the hassle of waiting in long lines to get an appointment. Safe blood transfusion is
                        a major issue when it comes to saving valuable life. Online blood donation service
                        will be a very efficient way of finding blood. As patients will be able to find blood
                        from donors and many other blood banks around the city. This type of web application
                        can be adopted by hospitals/clinics to manage their patient, doctor and blood banks.
                        Assurance of safe blood is done. When a new blood donor registers to the system the
                        donor is provided a date to attend a blood donation camp. During the campaign blood
                        samples are collated and tested. If the test results are positive blood bank staff
                        will publish the report and the donor will be eligible for responding to blood
                        request from the patients.

                    </p>
                </div>
                <div class="bg-gray p-l-20 p-b-20 p-t-20 p-r-20 ">
                    <h3 class="text-left">Our aims</h3>
                    <ul class="about_list">
                        <li>Availability of doctors in emergency cases so that patients are able to consult with the doctors.</li>
                        <li>Easy doctor appointment booking.</li>
                        <li>Manage patients easily, for example: report and prescription publishing.</li>
                        <li>Easy way to find blood and blood donor and ensure blood transfusion is safe.</li>
                        <li>Automate task in blood banks and allow easier blood stock maintenance.</li>
                        <li>Blood donation camps can be managed by the system and record data form the camp. </li>
                    </ul>
                </div>
            </div>
        </section>



        <div class="container">
            <div class="">

            </div>
            <div class="">

            </div>
        </div>


    </div>


@stop
