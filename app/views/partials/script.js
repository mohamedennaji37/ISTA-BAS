const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("toggleSidebar");
const paramBtn = document.getElementById("paramBtn");
const actionBtn = document.getElementById("actionBtn");
const paramDropdown = document.getElementById("paramDropdown");
const actionDropdown = document.getElementById("actionDropdown");
const content = document.getElementById("content");

let ignoreHide = false;

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("show");
});

paramBtn.addEventListener("click", (e) => {
    ignoreHide = true;
    setTimeout(() => ignoreHide = false, 300);
});

actionBtn.addEventListener("click", (e) => {
    ignoreHide = true;
    setTimeout(() => ignoreHide = false, 300);
});

document.querySelectorAll(".sidebar-menu-button, .dropdown-item").forEach(link => {
    link.addEventListener("click", () => {
        if (!ignoreHide && window.innerWidth <= 768) {
            sidebar.classList.remove("show");
        }
    });
});
const user = "Mohamed Eddamej";

// Select the element and insert the greeting
const welcomeElement = document.getElementById("User");
welcomeElement.textContent = ` ${user}`;
const button = document.getElementById("ban");
const icon = document.getElementById("icon");
let isBlocked = false;
button.addEventListener("click",function (){
    isBlocked = !isBlocked;
    if (isBlocked) {
        icon.innerHTML = '<i class="bi bi-block"></i>';
        button.textContent = "deBlock";
        button.style.backgroundColor = "green";

    }
    else {
        button.textContent = "Block";
        icon.innerHTML = '';
        button.style.backgroundColor = "red";
    }
})