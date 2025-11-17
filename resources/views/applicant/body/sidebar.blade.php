@php
$user=\App\Models\User::find(\Illuminate\Support\Facades\Auth::User()->id);
@endphp
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
{{--            <a href="{{route('applicant.dashboard')}}">    <img src="{{asset('adminbackend/assets/images/logo-img.png')}}" class="" width="155" height="55" alt="logo icon">--}}

            </a>
        </div>
        <div>
            <a href="">
                <h4 class="logo-text">My Dashboard</h4>
            </a>

        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
  @if($user->level==1)
        <ul class="metismenu" id="menu">
            <li>
                <div class="card-body">

{{--                    <button class="btn btn-danger" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>--}}
{{--                        <span class="visually-hidden"></span>--}}
                    </button>
                    <button class="btn btn-danger" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Awaiting Profile ...</button>

                    <hr>

                </div>
            </li>
        </ul>

    @else
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow" href="{{route('applicant.dprofile')}}">
                    <div class="parent-icon"><i class="bx bx-user"></i>
                    </div>
                    <div class="menu-title">My Profile</div>
                </a>

            </li>
            @if(Auth::user()->hasRole('applicant'))
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-error"></i>
                        </div>
                        <div class="menu-title">Errors</div>
                    </a>
                    <ul>
                        <li> <a href="errors-404-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>404 Error</a>
                        </li>
                        <li> <a href="errors-500-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>500 Error</a>
                        </li>
                        <li> <a href="errors-coming-soon.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>Coming Soon</a>
                        </li>
                        <li> <a href="error-blank-page.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>Blank Page</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bx bx-error"></i>
                    </div>
                    <div class="menu-title">My Profile</div>
                </a>
                <ul>
                    <li> <a href="errors-404-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>404 Error</a>
                    </li>

                </ul>
            </li>
        </ul>
    @endif
    <!--end navigation-->
</div>

