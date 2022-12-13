@php
if(Auth::user()->type == 'admin')
{
$setting = App\Models\Utility::getAdminPaymentSettings();
    if ($setting['color']) {
        $color = $setting['color'];
    }
    else{
    $color = 'theme-3';
    }
    $dark_mode = $setting['cust_darklayout'];
    $cust_theme_bg =$setting['cust_theme_bg'];
    $SITE_RTL = env('SITE_RTL');
     $company_logo = App\Models\Utility::get_logo();
}
else { 
    $setting = App\Models\Utility::getcompanySettings($currentWorkspace->id);
    $color = $setting->theme_color;
    $dark_mode = $setting->cust_darklayout; 
    $SITE_RTL = $setting->site_rtl;
    $cust_theme_bg = $setting->cust_theme_bg;
    $company_logo = App\Models\Utility::getcompanylogo($currentWorkspace->id);
}

   if($color == '' || $color == null){
      $settings = App\Models\Utility::getAdminPaymentSettings();
      $color = $settings['color'];           
   }

   if($dark_mode == '' || $dark_mode == null){
     $company_logo = App\Models\Utility::get_logo();
      $dark_mode = $settings['cust_darklayout'];
   }

   if($cust_theme_bg == '' || $dark_mode == null){
      $cust_theme_bg = $settings['cust_theme_bg'];
   }

    if($SITE_RTL == '' || $SITE_RTL == null){
      $SITE_RTL = env('SITE_RTL');
   }
@endphp
<nav class="dash-sidebar light-sidebar {{(isset($cust_theme_bg) && $cust_theme_bg == 'on') ? 'transprent-bg':''}}">
 
    <div class="navbar-wrapper">
      <div class="m-header main-logo">
        <a href="{{ route('home') }}" class="b-brand">
          <!-- ========   change your logo hear   ============ -->

           <img
            src="{{asset(Storage::url('logo/'.$company_logo))}}" alt="" class="" />
        </a>
      </div>
      <div class="navbar-content">
        <ul class="dash-navbar">
           @if(\Auth::guard('client')->check())
              <li class="dash-item dash-hasmenu">
                <a href="{{route('client.home')}}" class="dash-link {{ (Request::route()->getName() == 'home' || Request::route()->getName() == NULL || Request::route()->getName() == 'client.home') ? ' active' : '' }}">
                  <span class="dash-micon"><i class="ti ti-home"></i></span>
                  <span class="dash-mtext">{{ __('Dashboard') }}</span>


                </a>
              </li>
           @else
             <li class="dash-item dash-hasmenu">
                <a href="{{route('home')}}" class="dash-link  {{ (Request::route()->getName() == 'home' || Request::route()->getName() == NULL || Request::route()->getName() == 'client.home') ? ' active' : '' }}">
                 @if(Auth::user()->type == 'admin') <span class="dash-micon"><i class="ti ti-user"></i></span>
                  <span class="dash-mtext">{{ __('Users') }}</span>@else<span class="dash-micon"><i class="ti ti-home"></i></span>
                  <span class="dash-mtext">{{ __('Dashboard') }}</span> @endif
                </a>
              </li>
            @endif
            @if(isset($currentWorkspace) && $currentWorkspace)
            @auth('web')
          <li class="dash-item dash-hasmenu">
            <a href="{{ route('users.index',$currentWorkspace->slug) }}" class="dash-link {{ (Request::route()->getName() == 'users.index') ? ' active' : '' }}"><span class="dash-micon"> <i data-feather="user"></i></span><span
                    class="dash-mtext">{{ __('Users') }}</span></a>
          </li>
            @if($currentWorkspace->creater->id == Auth::user()->id)
            <li class="dash-item dash-hasmenu">
                <a href="{{ route('clients.index',$currentWorkspace->slug) }}" class="dash-link {{ (Request::route()->getName() == 'clients.index') ? ' active' : '' }}"><span class="dash-micon">  <i class="ti ti-brand-python"></i></span><span
                        class="dash-mtext"> {{ __('Clients') }}</span></a>
            </li>
            @endif
          <li class="dash-item {{ (Request::route()->getName() == 'projects.index' || Request::segment(2) == 'projects') ? ' active' : '' }}">
            <a href="{{ route('projects.index',$currentWorkspace->slug) }}" class="dash-link"><span class="dash-micon"> <i data-feather="briefcase"></i></span><span  class="dash-mtext">{{ __('Projects') }}</span></a>
          </li>
          <li class="dash-item {{ (Request::route()->getName() == 'tasks.index') ? ' active' : '' }}">
            <a href="{{ route('tasks.index',$currentWorkspace->slug) }}" class="dash-link "><span class="dash-micon"><i data-feather="list"></i></span><span
                    class="dash-mtext">{{ __('Tasks') }}</span></a>
          </li>

          <li class="dash-item {{ (Request::route()->getName() == 'timesheet.index') ? ' active' : '' }}">
            <a href="{{route('timesheet.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="clock"></i></span><span
                    class="dash-mtext">{{ __('Timesheet') }}</span></a>
          </li>
            @if(Auth::user()->type == 'user'&& $currentWorkspace->creater->id == Auth::user()->id)
          <li class="dash-item {{\Request::route()->getName() == 'time.tracker'?'active':''}}">
            <a href="{{route('time.tracker',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="watch"></i></span><span
                    class="dash-mtext">{{ __('Tracker') }}</span></a>
          </li>
           @endif
          @if($currentWorkspace->creater->id == Auth::user()->id)
          <li class="dash-item {{ (Request::route()->getName() == 'invoices.index' || Request::segment(2) == 'invoices') ? ' active' : '' }}">
            <a href="{{ route('invoices.index',$currentWorkspace->slug) }}" class="dash-link"><span class="dash-micon"><i data-feather="printer"></i></span><span
                    class="dash-mtext">{{ __('Invoices') }} </span></a>
          </li>
         @endif
          <li class="dash-item {{ (Request::route()->getName() == 'calender.index') ? ' active' : '' }}">
            <a href="{{route('calender.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="calendar"></i></span><span
                    class="dash-mtext">{{ __('Calender') }}</span></a>
          </li>
          <li class="dash-item {{ (Request::route()->getName() == 'notes.index') ? ' active' : '' }}">
            <a href="{{route('notes.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="clipboard"></i></span><span
                    class="dash-mtext">{{ __('Notes') }} </span></a>
          </li>
            @if(env('CHAT_MODULE') == 'on')
          <li class="dash-item {{ (Request::route()->getName() == 'chats') ? ' active' : '' }}">
            <a href="{{route('chats')}}" class="dash-link"><span class="dash-micon"><i class="ti ti-message-circle"></i></span><span
                    class="dash-mtext">{{ __('Chats') }}</span></a>

          </li>
            @endif
        @elseauth
            <li class="dash-item {{ (Request::route()->getName() == 'client.projects.index' || Request::segment(3) == 'projects') ? ' active' : '' }}">
            <a href="{{ route('client.projects.index',$currentWorkspace->slug) }}" class="dash-link "><span class="dash-micon"><i data-feather="briefcase"></i></span><span
                class="dash-mtext">{{ __('Projects') }}</span></a>
          </li>

            <li class="dash-item {{ (Request::route()->getName() == 'client.timesheet.index') ? ' active' : '' }}">
            <a href="{{route('client.timesheet.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="clock"></i></span><span
                class="dash-mtext">{{ __('Timesheet') }}</span></a>
          </li>

          <li class="dash-item {{ (Request::route()->getName() == 'client.invoices.index') ? ' active' : '' }}">
            <a href="{{ route('client.invoices.index',$currentWorkspace->slug) }}" class="dash-link "><span class="dash-micon"><i data-feather="printer"></i></span><span
                class="dash-mtext">{{ __('Invoices') }} </span></a>
          </li>


          <li class="dash-item {{ (Request::route()->getName() == 'client.calender.index') ? ' active' : '' }}">
            <a href="{{route('client.calender.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="calendar"></i></span><span
                class="dash-mtext">{{ __('Calender') }}</span></a>
          </li>

          <li class="dash-item {{ (Request::route()->getName() == 'client.zoom-meeting.index') ? ' active' : '' }}">
            <a href="{{route('client.zoom-meeting.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="video"></i></span><span
                    class="dash-mtext">{{ __('Zoom Meeting') }}</span></a>

          </li>
           @endauth
                @endif
         @if(isset($currentWorkspace) && $currentWorkspace)
         @auth('web')
            <li class="dash-item {{ (Request::route()->getName() == 'zoom-meeting.index') ? ' active' : '' }}">
            <a href="{{route('zoom-meeting.index',$currentWorkspace->slug)}}" class="dash-link "><span class="dash-micon"><i data-feather="video"></i></span><span
                class="dash-mtext">{{ __('Zoom Meeting') }}</span></a>

          </li>

          @endauth
        @endif
         @if(Auth::user()->type == 'admin')
          <li class="dash-item {{ (Request::route()->getName() == 'lang_workspace') ? ' active' : '' }}">
            <a href="{{ route('lang_workspace') }}" class="dash-link "><span class="dash-micon"><i class="ti ti-world nocolor"></i></span><span
                class="dash-mtext">{{ __('Languages') }}</span></a>
          </li>
           <li class="dash-item {{ (Request::route()->getName() == 'settings.index') ? ' active' : '' }}">
              <a href="{{ route('settings.index') }}" class="dash-link "><span class="dash-micon"><i data-feather="settings"></i></span><span
                  class="dash-mtext"> {{ __('Settings') }}</span></a>
            </li>

         @endif
         @if(isset($currentWorkspace) && $currentWorkspace && $currentWorkspace->creater->id == Auth::user()->id && Auth::user()->getGuard() != 'client')

          <li class="dash-item {{ (Request::route()->getName() == 'workspace.settings') ? ' active' : '' }}">
            <a href="{{ route('workspace.settings',$currentWorkspace->slug) }}" class="dash-link "><span class="dash-micon"><i data-feather="settings"></i></span><span
                    class="dash-mtext">{{ __('Settings') }}</span></a>
          </li>
         @endif
      </div>
    </div>
  </nav>
