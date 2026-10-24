<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|bricolage-grotesque:600,700&display=swap" rel="stylesheet">
    <style>
        :root{
            --ink:#0f2a2e; --ink-soft:#31484c; --brand:#0d7377; --brand-dark:#095659; --brand-tint:#def1f0;
            --mist:#eef3f2; --edge:#d6e2e0; --signal:#2dbd73; --alert:#c8412f;
        }
        *{ margin:0; padding:0; box-sizing:border-box; }

        body{
            min-height:100vh;
            padding:16px;
            display:flex;
            background:var(--mist);
            color:var(--ink);
            font-family:'Manrope', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            -webkit-font-smoothing:antialiased;
        }

        :focus-visible{ outline:3px solid rgba(13,115,119,.45); outline-offset:2px; }

        .chat-box{
            width:100%;
            max-width:1180px;
            height:calc(100vh - 32px);
            margin:auto;
            display:flex;
            overflow:hidden;
            background:#fff;
            border:1px solid var(--edge);
            border-radius:20px;
            box-shadow:0 1px 2px rgba(15,42,46,.06), 0 18px 40px -16px rgba(15,42,46,.25);
        }

        /* ---------- Sidebar ---------- */
        .sidebar{
            width:300px;
            flex-shrink:0;
            display:flex;
            flex-direction:column;
            background:var(--ink);
            color:#fff;
        }

        .sidebar-header{
            display:flex;
            align-items:center;
            gap:12px;
            padding:20px 18px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .brand-mark{
            width:40px; height:40px; flex-shrink:0;
            display:grid; place-items:center;
            border-radius:12px;
            background:rgba(255,255,255,.1);
            box-shadow:inset 0 0 0 1px rgba(255,255,255,.18);
        }
        .brand-mark svg{ width:20px; height:20px; }
        .brand-text{ min-width:0; }
        .brand-text strong{
            display:block;
            font-family:'Bricolage Grotesque','Manrope',sans-serif;
            font-size:18px; font-weight:600; letter-spacing:-.01em;
        }
        .brand-text small{
            display:block; margin-top:2px;
            font-size:12.5px; color:rgba(255,255,255,.6);
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }

        .user-list{
            flex:1;
            overflow-y:auto;
            padding:10px;
        }
        .user-list::-webkit-scrollbar{ width:6px; }
        .user-list::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.18); border-radius:6px; }

        .user-item{
            position:relative;
            display:flex;
            align-items:center;
            gap:12px;
            padding:10px 12px;
            margin-bottom:2px;
            border-radius:12px;
            cursor:pointer;
            transition:background .15s ease;
        }
        .user-item:hover{ background:rgba(255,255,255,.07); }
        .user-item.active{ background:rgba(255,255,255,.13); }
        .user-item.active::before{
            content:""; position:absolute; left:-10px; top:12px; bottom:12px;
            width:4px; border-radius:0 4px 4px 0; background:var(--signal);
        }

        .avatar{
            width:40px; height:40px; flex-shrink:0;
            display:flex; justify-content:center; align-items:center;
            border-radius:50%;
            background:var(--brand);
            color:#fff;
            font-weight:700; font-size:15px;
        }
        .user-item:nth-child(5n+2) .avatar{ background:#7a5ac7; }
        .user-item:nth-child(5n+3) .avatar{ background:#c46a2f; }
        .user-item:nth-child(5n+4) .avatar{ background:#b0436e; }
        .user-item:nth-child(5n+5) .avatar{ background:#3a7bd5; }

        .user-name{
            font-size:15px; font-weight:600;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }

        .sidebar-footer{
            padding:10px;
            border-top:1px solid rgba(255,255,255,.08);
        }
        .side-link{
            display:flex; align-items:center; gap:12px;
            padding:10px 12px;
            border-radius:10px;
            color:rgba(255,255,255,.75);
            font-size:14px; font-weight:600;
            text-decoration:none;
            transition:background .15s ease, color .15s ease;
        }
        .side-link:hover{ background:rgba(255,255,255,.08); color:#fff; }
        .side-link svg{ width:18px; height:18px; flex-shrink:0; }
        .side-link.logout:hover{ color:#ff9b8c; }

        /* ---------- Main ---------- */
        .chat-main{
            flex:1;
            min-width:0;
            display:flex;
            flex-direction:column;
            background:var(--mist);
        }

        .chat-header{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px 22px;
            background:#fff;
            border-bottom:1px solid var(--edge);
            font-family:'Bricolage Grotesque','Manrope',sans-serif;
            font-size:17px; font-weight:600;
        }

        #placeholder{
            flex:1;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            gap:6px;
            padding:24px;
            text-align:center;
            color:var(--ink-soft);
        }
        #placeholder .ph-icon{
            width:64px; height:64px; margin-bottom:10px;
            display:grid; place-items:center;
            border-radius:20px;
            background:var(--brand-tint);
            color:var(--brand-dark);
        }
        #placeholder .ph-icon svg{ width:28px; height:28px; }
        #placeholder strong{
            font-family:'Bricolage Grotesque','Manrope',sans-serif;
            font-size:20px; font-weight:600; color:var(--ink);
        }
        #placeholder span{ font-size:14.5px; }

        #messagesArea{
            flex:1;
            overflow-y:auto;
            padding:24px 22px;
            background:var(--mist);
        }

        .bubble-wrap{ display:flex; margin-bottom:10px; }
        .bubble-wrap.mine{ justify-content:flex-end; }
        .bubble-wrap.theirs{ justify-content:flex-start; }

        .bubble{
            max-width:min(70%, 520px);
            padding:10px 14px 8px;
            border-radius:18px;
            word-wrap:break-word;
            overflow-wrap:anywhere;
            font-size:14.5px;
            line-height:1.5;
        }
        .bubble.mine{
            background:var(--brand);
            color:#fff;
            border-bottom-right-radius:5px;
        }
        .bubble.theirs{
            background:#fff;
            color:var(--ink);
            border:1px solid var(--edge);
            border-bottom-left-radius:5px;
        }
        .bubble.theirs > div[style*="font-size"]{ color:var(--brand) !important; }

        .meta{
            margin-top:4px;
            font-size:11px;
            opacity:.65;
            text-align:right;
        }

        .bubble .btn-danger{
            --bs-btn-bg:rgba(255,255,255,.16);
            --bs-btn-border-color:transparent;
            --bs-btn-hover-bg:var(--alert);
            --bs-btn-hover-border-color:var(--alert);
            --bs-btn-active-bg:var(--alert);
            --bs-btn-active-border-color:var(--alert);
            padding:2px 10px;
            font-size:12px; font-weight:600;
            border-radius:8px;
        }

        /* ---------- Input ---------- */
        .chat-input{
            display:flex;
            align-items:flex-end;
            gap:10px;
            padding:14px 18px;
            background:#fff;
            border-top:1px solid var(--edge);
        }
        .chat-input textarea{
            flex:1;
            min-height:46px;
            resize:none;
            padding:12px 16px;
            border:1px solid var(--edge);
            border-radius:14px;
            background:var(--mist);
            font:inherit; font-size:14.5px; color:var(--ink);
            outline:none;
            transition:border-color .15s ease, box-shadow .15s ease, background .15s ease;
        }
        .chat-input textarea::placeholder{ color:rgba(15,42,46,.45); }
        .chat-input textarea:focus{
            background:#fff;
            border-color:var(--brand);
            box-shadow:0 0 0 4px rgba(13,115,119,.15);
        }

        .send-btn{
            width:46px; height:46px; flex-shrink:0;
            display:grid; place-items:center;
            border:none;
            border-radius:14px;
            background:var(--brand);
            color:#fff;
            cursor:pointer;
            transition:background .15s ease, transform .1s ease;
        }
        .send-btn svg{ width:20px; height:20px; }
        .send-btn:hover{ background:var(--brand-dark); }
        .send-btn:active{ transform:scale(.95); }

        /* ---------- Extras: search, motion, input polish ---------- */
        .user-search{ padding:12px 14px 4px; }
        .user-search input{
            width:100%;
            padding:10px 14px;
            border:1px solid rgba(255,255,255,.14);
            border-radius:12px;
            background:rgba(255,255,255,.07);
            color:#fff;
            font:inherit; font-size:14px;
            outline:none;
            transition:background .15s ease, border-color .15s ease;
        }
        .user-search input::placeholder{ color:rgba(255,255,255,.5); }
        .user-search input:focus{ background:rgba(255,255,255,.12); border-color:rgba(255,255,255,.35); }
        .user-empty{ display:none; padding:18px 12px; text-align:center; font-size:13.5px; color:rgba(255,255,255,.55); }

        #messagesArea{ scroll-behavior:smooth; }
        #messagesArea::-webkit-scrollbar{ width:8px; }
        #messagesArea::-webkit-scrollbar-thumb{ background:#c3d3d0; border-radius:8px; }

        .bubble-wrap{ animation:msg-in .18s ease-out both; }
        @keyframes msg-in{ from{ opacity:0; transform:translateY(6px); } to{ opacity:1; transform:none; } }

        .chat-input textarea{ max-height:140px; line-height:1.45; }
        .send-btn.is-empty{ background:#9db8b6; cursor:default; }
        .send-btn.is-empty:hover{ background:#9db8b6; }

        /* ---------- Small screens: icon-only sidebar ---------- */
        @media (max-width: 720px){
            body{ padding:0; }
            .chat-box{ height:100vh; max-width:none; border:0; border-radius:0; }
            .sidebar{ width:76px; }
            .brand-text, .user-name, .side-link span, .user-search{ display:none; }
            .sidebar-header{ justify-content:center; padding:18px 0; }
            .user-item{ justify-content:center; padding:10px 0; }
            .user-item.active::before{ left:0; }
            .side-link{ justify-content:center; padding:12px 0; }
            #messagesArea{ padding:16px 12px; }
            .bubble{ max-width:85%; }
        }

        @media (prefers-reduced-motion: reduce){
            *{ transition:none !important; animation:none !important; }
            #messagesArea{ scroll-behavior:auto; }
        }
    </style>
</head>
<body>

<div class="chat-box">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="brand-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
            </span>
            <div class="brand-text">
                <strong>Messages</strong>
                <small>{{ auth()->user()->name }}</small>
            </div>
        </div>

        <div class="user-search">
            <input type="search" id="userSearch" placeholder="Search people" autocomplete="off" aria-label="Search people">
        </div>

        <div class="user-list">
            @foreach($users as $user)
                <div class="user-item" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                     onclick="openChat({{ $user->id }}, '{{ addslashes($user->name) }}')">
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="user-name">{{ $user->name }}</div>
                </div>
            @endforeach
            <div class="user-empty" id="userEmpty">No one matches that name.</div>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('dashboard') }}" class="side-link" title="Dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('user.create') }}" class="side-link" title="Add user">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                <span>Add user</span>
            </a>

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('lf').submit();"
               class="side-link logout" title="Log out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
                <span>Log out</span>
            </a>
            <form id="lf" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="chat-main">

        {{-- Placeholder --}}
        <div id="placeholder">
            <div class="ph-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.6-.8L3 21l1.9-5.1A8.4 8.4 0 1 1 21 11.5Z"/></svg>
            </div>
            <strong>Pick someone to message</strong>
            <span>Choose a person on the left to open your conversation.</span>
        </div>

        <div id="chatArea" style="display:none; flex:1; flex-direction:column; min-height:0;">
            <div class="chat-header">
                <div class="avatar" id="headerAvatar">U</div>
                <span id="headerName">User</span>
            </div>

            <div id="messagesArea"></div>

            <div class="chat-input">
                <textarea id="msgInput" rows="1" placeholder="Write a message. Press Enter to send."></textarea>
                <button class="send-btn" onclick="sendMessage()" aria-label="Send message">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7Z"/></svg>
                </button>
            </div>
        </div>

    </div>
</div>


@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
const AUTH_ID = {{ auth()->id() }};
let activeUserId = null;


async function openChat(userId, userName) {
    activeUserId = userId;


    document.querySelectorAll('.user-item').forEach(el => el.classList.remove('active'));
    document.querySelector(`.user-item[data-id="${userId}"]`).classList.add('active');


    document.getElementById('headerAvatar').textContent = userName.charAt(0).toUpperCase();
    document.getElementById('headerName').textContent    = userName;


    document.getElementById('placeholder').style.display = 'none';
    const chatArea = document.getElementById('chatArea');
    chatArea.style.display = 'flex';

    // Load messages
    document.getElementById('messagesArea').innerHTML = '<div class="text-center text-muted p-3">Loading…</div>';

    const res  = await fetch(`/chat/messages/${userId}`);
    const data = await res.json();

    renderMessages(data.messages);
}


function renderMessages(messages) {
    const area = document.getElementById('messagesArea');
    area.innerHTML = '';
    messages.forEach(m => area.insertAdjacentHTML('beforeend', bubbleHTML(m)));
    scrollBottom();
}


function bubbleHTML(m) {
    const side = m.is_mine ? 'mine' : 'theirs';
    const name = m.is_mine ? '' : `<div style="font-size:.72rem;color:#075e54;font-weight:600;margin-bottom:2px">${esc(m.sender_name)}</div>`;
    return `
    <div class="bubble-wrap ${side}">
        <div class="bubble ${side}">
            ${name}
            ${esc(m.message).replace(/\n/g,'<br>')}
            <div class="meta">${m.time}</div>
        </div>
    </div>`;
}

 
async function sendMessage() {
    const input = document.getElementById('msgInput');
    const text  = input.value.trim();
    if (!text || !activeUserId) return;
    input.value = '';

    const res = await fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
        },
        body: JSON.stringify({ receiver_id: activeUserId, message: text }),
    });

    const msg = await res.json();
    document.getElementById('messagesArea').insertAdjacentHTML('beforeend', bubbleHTML(msg));
    scrollBottom();



    
}


document.getElementById('msgInput').addEventListener('keydown', e => {                                                                          
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
});


document.addEventListener('DOMContentLoaded', () => {
    if (!window.Echo) {
        console.error('Echo not loaded!');
        return;
    }

    window.Echo.private(`chat.${AUTH_ID}`)
        .listen('.MessageSent', (data) => {
            console.log('Received:', data);

            if (parseInt(activeUserId) === parseInt(data.sender_id)) {
                const area = document.getElementById('messagesArea');
                area.insertAdjacentHTML('beforeend', bubbleHTML({
                    id: data.id,
                    message: data.message,
                    sender_name: data.sender_name,
                    time: data.time,
                    is_mine: false,
                }));
                scrollBottom();
            }
        });
});


function scrollBottom() {
    const area = document.getElementById('messagesArea');
    area.scrollTop = area.scrollHeight;
}

function esc(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}  


function bubbleHTML(m) {
    const side = m.is_mine ? 'mine' : 'theirs';

    const deleteBtn = m.is_mine
        ? `<button class="btn btn-sm btn-danger mt-1"
             onclick="deleteMessage(${m.id})">
             Delete
           </button>`
        : '';

    const name = m.is_mine
        ? ''
        : `<div style="font-size:.72rem;color:#075e54;font-weight:600;margin-bottom:2px">
              ${esc(m.sender_name)}
           </div>`;

    return `
    <div class="bubble-wrap ${side}" id="message-${m.id}">
        <div class="bubble ${side}">
            ${name}
            ${esc(m.message).replace(/\n/g,'<br>')}
            <div class="meta">${m.time}</div>
            ${deleteBtn}
        </div>
    </div>`;
}

// async function deleteMessage(messageId) {

//     const result = await Swal.fire({
//         title: 'Delete Message?',
//         text: 'This action cannot be undone.',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Yes, delete',
//         cancelButtonText: 'Cancel',
//         customClass: {
//             confirmButton: 'btn btn-danger fw-bold',
//             cancelButton: 'btn btn-light fw-bold'
//         },
//         buttonsStyling: false
//     });

//     if (!result.isConfirmed) {
//         return;
//     }

//     try {
//         const res = await fetch(`/chat/delete/${messageId}`, {
//             method: 'DELETE',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//                 'Accept': 'application/json'
//             }
//         });

//         const data = await res.json();

//         if (data.success) {
//             document.getElementById(`message-${messageId}`)?.remove();

//             Swal.fire({
//                 icon: 'success',
//                 title: 'Deleted',
//                 text: 'Message deleted successfully',
//                 timer: 1500,
//                 showConfirmButton: false
//             });
//         } else {
//             Swal.fire('Error', data.message || 'Delete failed', 'error');
//         }

//     } catch (error) {
//         console.error(error);
//         Swal.fire('Error', 'Something went wrong', 'error');
//     }
// }




async function deleteMessage(messageId) {

    if (!confirm('Delete this message?')) {
        return;
    }

    try {
        const res = await fetch(`/chat/delete/${messageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        });

        console.log(res.status);

        const data = await res.json();
        console.log(data);

        if (data.success) {
            document.getElementById(`message-${messageId}`)?.remove();
        }

    } catch (e) {
        console.error(e);
    }
}

</script>

{{-- UI helpers only: they never touch the chat logic above --}}
<script>
(function () {
    const input   = document.getElementById('msgInput');
    const sendBtn = document.querySelector('.send-btn');

    // Textarea grows with the text (up to 140px) and the send button dims when empty
    function refreshInput() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 140) + 'px';
        sendBtn.classList.toggle('is-empty', !input.value.trim());
    }
    input.addEventListener('input', refreshInput);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) setTimeout(refreshInput, 0);   // message was just sent
    });
    sendBtn.addEventListener('click', () => setTimeout(refreshInput, 0));
    refreshInput();

    // Focus the message box after you pick someone
    document.querySelectorAll('.user-item').forEach(el => {
        el.addEventListener('click', () => setTimeout(() => input.focus(), 60));
    });

    // Search people in the sidebar
    const search = document.getElementById('userSearch');
    const empty  = document.getElementById('userEmpty');
    search.addEventListener('input', () => {
        const q = search.value.trim().toLowerCase();
        let shown = 0;
        document.querySelectorAll('.user-item').forEach(el => {
            const match = el.dataset.name.toLowerCase().includes(q);
            el.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        empty.style.display = shown ? 'none' : 'block';
    });
})();
</script>
</body>
</html>