@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')

    <section id="product">
        <div class="container">
            <!--  breadcrumb -->
            {!! Breadcrumbs::render('lien-he') !!}
            <!-- Contact Us-->
            <h1 class="heading1"><span class="maintext">Contact</span><span class="subtext"> Contact Us for more</span>
            </h1>
            <div class="row">
                <div class="span9">
                    @if(Session::has('co_level'))
                        <div class="alert alert-{{ Session::get('co_level') }}">
                            {{ Session::get('co_messages') }}
                        </div>
                    @endif
                    @include('admin.blocks.errors')
                    <form class="form-horizontal" action="{!! route('postlienhe') !!}" method="post">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <fieldset>
                            <div class="control-group">
                                <label for="name" class="control-label">Name <span class="required">*</span></label>

                                <div class="controls">
                                    <input type="text" class="required span6" id="name" value="{!! old('name') !!}" name="name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="email" class="control-label">Email <span class="required">*</span></label>

                                <div class="controls">
                                    <input type="email" class="required email span6" id="email" value="{!! old('email') !!}" name="email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="title" class="control-label">Title <span class="required">*</span></label>

                                <div class="controls">
                                    <input type="text" class="required title span6" id="title" value="{!! old('title') !!}" name="title">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="message" class="control-label">Message</label>

                                <div class="controls">
                                    <textarea class="required span7" rows="6" cols="90" id="message"
                                              name="message">{!! old('message') !!}</textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input class="btn btn-orange" type="submit" value="Submit" id="submit_id">
                                <input class="btn" type="reset" value="Reset">
                            </div>
                        </fieldset>
                    </form>
                </div>

                <!-- Sidebar Start-->
                <div class="span3">
                    <aside>
                        <div class="sidewidt">
                            <h2 class="heading2"><span>Contact Info</span></h2>

                            <p> Lorem Ipsum is simply<br>
                                Lorem Ipsum is simply<br>
                                Lorem Ipsum is simply<br>
                                <br>
                                Phone: (012) 333-7890<br>
                                Fax: (123) 444-7890<br>
                                Email: test@contactus.com<br>
                                Web: yourcompanyname.com<br>
                            </p>
                        </div>
                    </aside>
                </div>
                <!-- Sidebar End-->

            </div>
        </div>
    </section>
@endsection