const form = document.querySelector(".typing-area");
const incoming_id = form.querySelector("input[name='incoming_id']").value;
const inputField = form.querySelector("input[name='message']");
const sendBtn = form.querySelector("button");
const chatBox = document.querySelector(".chat-box");

// Prevent form submission
form.onsubmit = (e) => {
  e.preventDefault();
};

// Focus input field
inputField.focus();

// Handle input field changes
inputField.onkeyup = () => {
  if (inputField.value.trim() != "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};

// Handle send button click
sendBtn.onclick = () => {
  if (!inputField.value.trim()) return;

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "insert-chat.php", true);

  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      inputField.value = "";
      sendBtn.classList.remove("active");
      scrollToBottom();
    }
  };

  xhr.onerror = () => {
    console.error("Error sending message");
  };

  let formData = new FormData(form);
  xhr.send(formData);
};

// Chat box scroll behavior
chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

// Function to fetch messages
function fetchMessages() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "get-chat.php", true);

  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      chatBox.innerHTML = xhr.response;
      if (!chatBox.classList.contains("active")) {
        scrollToBottom();
      }
    }
  };

  xhr.onerror = () => {
    console.error("Error fetching messages");
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + encodeURIComponent(incoming_id));
}

// Start periodic updates
setInterval(fetchMessages, 500);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}

// Initial fetch
fetchMessages();
