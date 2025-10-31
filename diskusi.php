<?php
// public/diskusi.php
require_once __DIR__ . '/includes/db.php';
require_login();

$user = current_user($pdo);
$page_title = 'Diskusi Real-time';
require __DIR__ . '/includes/header.php';
?>

<style>
.chat-wrapper { max-width:900px; margin:0 auto; }
.chat-window { height:60vh; overflow-y:auto; background:#f7fbff; padding:16px; border-radius:12px; border:1px solid #e6f3ff; display:flex; flex-direction:column-reverse; }
.msg { padding:10px 14px; border-radius:12px; margin-bottom:10px; max-width:78%; display:inline-block; line-height:1.4; position:relative; }
.msg .meta { font-size:12px; color:#6b7280; margin-bottom:6px; }
.msg.out { background: linear-gradient(90deg,#cfefff,#e6f9ff); align-self:flex-end; }
.msg.in { background:#fff; border:1px solid #e6f3ff; align-self:flex-start; }
.chat-row { display:flex; flex-direction:column; }
.chat-input { margin-top:10px; display:flex; gap:8px; align-items:center; }
.chat-input textarea { resize:none; height:56px; border-radius:10px; border:1px solid #dbeafe; padding:10px; flex:1; }
.chat-input button { min-width:110px; }
.user-badge { font-weight:600; color:#0b6fb3; }
#imagePreview { max-height:120px; margin-top:6px; display:none; border-radius:8px; border:1px solid #ccc; }
label.upload-btn { cursor:pointer; background:#e7f3ff; border-radius:10px; padding:10px; border:1px solid #cce0ff; }
.msg img.chat-img { max-width:200px; border-radius:8px; margin-top:6px; }
</style>

<div class="chat-wrapper">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-chat-dots"></i> Forum Diskusi — EduNetworkTech</h4>
    <div><span class="text-muted">Masuk sebagai</span> <span class="user-badge"><?= htmlspecialchars($user['full_name'] ?? $user['username']) ?></span></div>
  </div>

  <div id="chatWindow" class="chat-window">
    <div id="messagesContainer"></div>
  </div>

  <form id="chatForm" class="chat-input mt-3" enctype="multipart/form-data">
    <label for="imageUpload" class="upload-btn">
      <i class="bi bi-paperclip"></i>
    </label>
    <input type="file" id="imageUpload" name="image" accept="image/*" style="display:none;">
    <textarea id="msgInput" name="pesan" placeholder="Tulis pesan... (Enter = kirim, Shift+Enter = baris baru)"></textarea>
    <button type="submit" id="sendBtn" class="btn btn-primary">Kirim <i class="bi bi-send ms-1"></i></button>
  </form>
  <img id="imagePreview" alt="Preview Gambar">
</div>

<script>
const userId = <?= json_encode($user['id']) ?>;
let lastId = 0;

const messagesContainer = document.getElementById('messagesContainer');
const chatWindow = document.getElementById('chatWindow');
const msgInput = document.getElementById('msgInput');
const sendBtn = document.getElementById('sendBtn');
const chatForm = document.getElementById('chatForm');
const imageInput = document.getElementById('imageUpload');
const imagePreview = document.getElementById('imagePreview');

function escapeHtml(s) {
  return s.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
}
function nl2br(str){ return str.replace(/\n/g,'<br>'); }

function renderMessage(msg) {
  const wrapper = document.createElement('div');
  wrapper.className = 'chat-row';
  const box = document.createElement('div');
  box.className = 'msg ' + (msg.user_id == userId ? 'out' : 'in');
  const meta = `<div class="meta"><strong>${escapeHtml(msg.full_name || 'Pengguna')}</strong> &middot; <small>${escapeHtml(msg.role || '')}</small> &nbsp; <span class="text-muted">${escapeHtml(msg.created_at)}</span></div>`;
  let body = msg.pesan ? `<div>${nl2br(escapeHtml(msg.pesan))}</div>` : '';
  if (msg.image_path) {
    body += `<img src="${escapeHtml(msg.image_path)}" class="chat-img" alt="gambar">`;
  }
  box.innerHTML = meta + body;
  wrapper.appendChild(box);
  messagesContainer.appendChild(wrapper);
  lastId = Math.max(lastId, parseInt(msg.id));
  chatWindow.scrollTop = 0;
}

async function fetchMessages() {
  try {
    const res = await fetch('api/fetch_messages.php?after=' + lastId);
    if (!res.ok) return;
    const data = await res.json();
    if (Array.isArray(data) && data.length) {
      data.forEach(m => renderMessage(m));
    }
  } catch(e){ console.error(e); }
}

// preview gambar
imageInput.addEventListener('change', () => {
  const file = imageInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => {
      imagePreview.src = e.target.result;
      imagePreview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    imagePreview.style.display = 'none';
  }
});

// kirim pesan (text + optional image)
chatForm.addEventListener('submit', async e => {
  e.preventDefault();
  const pesan = msgInput.value.trim();
  const file = imageInput.files[0];
  if (!pesan && !file) return;

  const formData = new FormData(chatForm);
  sendBtn.disabled = true;

  try {
    const res = await fetch('api/post_message.php', { method:'POST', body: formData });
    const data = await res.json();
    if (data.success) {
      renderMessage(data.message);
      msgInput.value = '';
      chatForm.reset();
      imagePreview.style.display = 'none';
    }
  } catch (err) {
    console.error(err);
  } finally {
    sendBtn.disabled = false;
  }
});

// Enter untuk kirim
msgInput.addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) {
    e.preventDefault();
    chatForm.dispatchEvent(new Event('submit'));
  }
});

fetchMessages();
setInterval(fetchMessages, 2000);
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
