@if($milestone && $currentWorkspace)
    <form class="" method="post" action="@auth('web'){{ route('projects.milestone.update',[$currentWorkspace->slug,$milestone->id]) }}@elseauth{{ route('client.projects.milestone.update',[$currentWorkspace->slug,$milestone->id]) }}@endauth">
        @csrf
         <div class="modal-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="milestone-title" class="col-form-label">{{ __('Milestone Title')}}</label>
                    <input type="text" class="form-control form-control-light" id="milestone-title" placeholder="{{ __('Enter Title')}}" value="{{$milestone->title}}" name="title" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="milestone-status" class="col-form-label">{{ __('Status')}}</label>
                    <select class="form-control select2" name="status" id="milestone-status" required>
                        <option value="incomplete" @if($milestone->status=='incomplete') selected @endif>{{ __('Incomplete')}}</option>
                        <option value="complete" @if($milestone->status=='complete') selected @endif>{{ __('Complete')}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="milestone-title" class="col-form-label">{{ __('Milestone Cost')}}</label>
            <div class="form-icon-user">
                <span class="currency-icon bg-primary">{{ (!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'}}</span>
                <input type="number" class="form-control form-control-light currency_input" id="milestone-title" placeholder="{{ __('Enter Cost')}}" value="{{$milestone->cost}}" min="0" name="cost" required>
            </div>
        </div>
        <div class="form-group">
            <label for="task-summary" class="col-form-label">{{ __('Summary')}}</label>
            <textarea class="form-control form-control-light" id="task-summary" rows="3" name="summary">{{$milestone->summary}}</textarea>
        </div>
     </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close')}}</button>
            <input type="submit" value="{{ __('Save Changes')}}" class="btn  btn-primary">
        </div>
    </form>
@else
    <div class="container mt-5">
        <div class="card">
            <div class="card-body p-4">
                <div class="page-error">
                    <div class="page-inner">
                        <h1>404</h1>
                        <div class="page-description">
                            {{ __('Page Not Found') }}
                        </div>
                        <div class="page-search">
                            <p class="text-muted mt-3">{{ __("It's looking like you may have taken a wrong turn. Don't worry... it happens to the best of us. Here's a little tip that might help you get back on track.")}}</p>
                            <div class="mt-3">
                                <a class="btn-return-home badge-blue" href="{{route('home')}}"><i class="fas fa-reply"></i> {{ __('Return Home')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
