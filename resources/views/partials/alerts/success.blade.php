<div class="row {{ $payload['classes'] }}" style="
padding: 15px;
color: #fff;
background: #aad26f;
border-radius: 5px;
margin-bottom: 15px;
">
<div class="message message-error">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" style="fill: none !important;" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"/></svg>{{ $payload['message'] }}
</div>
</div>
