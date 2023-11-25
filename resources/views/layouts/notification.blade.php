@if (\Auth::user()->unreadNotifications->count() > 0)
    <li class="nav-item dropdown mr-n3">
        <a class="nav-link" data-toggle="dropdown" title="Notificações" href="#" aria-expanded="false">
            <i class="fas fa-bell fa-fw bell"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-dark navbar-badge">{{ \Auth::user()->unreadNotifications->count() }}</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <span class="dropdown-header"><b>Notificações</b></span>
            
            <div class="dropdown-divider"></div>
            
            <div id="ticket-alert">
                @foreach(\Auth::user()->unreadNotifications()->limit(4)->get() as $notification)
                    @if ($notification->type == 'App\Notifications\MaintenanceNotification')
                    
                    <a class="dropdown-item d-flex align-items-center header-notification"
                            class=""
                            data-id="{{ $notification->id }}"
                            data-route="{{ action([\App\Http\Controllers\TicketController::class, 'edit'], $notification->data['id']) }}" 
                            data-url="{{ action([App\Http\Controllers\NotificationController::class, 'markAsRead']) }}"
                            href="javascript:;">
                        <div class="mr-3">
                            <div class="icon-circle bg-dark">
                                <i class="fa-solid fa-map-location-dot fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $notification->data['start_date'] }}</div>
                            <span><b>Ponto -</b> {{ $notification->data['place_name'] }}</span><br>
                            <span><b>Status -</b> {{ $notification->data['status'] }}</span><br>
                            <span><b>Técnico -</b> {{ $notification->data['technician_name'] }}</span>
                            <br>
                            <b>Observação:</b> <br>
                            @foreach ($notification->data['message'] as $message)
                            <span>- {{ $message }}</span> <br>
                            @endforeach
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    @endif
                @endforeach
            </div>
            <a class="dropdown-item text-center text-gray-500" href="{{ action([\App\Http\Controllers\NotificationController::class, 'index']) }}"><b>Mostrar todas</b></a>
        </div>
    </li>
@endif