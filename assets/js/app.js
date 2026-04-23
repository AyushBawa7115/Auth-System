function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);

    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Hide";
    } else {
        input.type = "password";
        btn.textContent = "Show";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const glow = document.querySelector(".cursor-glow");

    document.addEventListener("mousemove", function (e) {
        if (glow) {
            glow.style.left = e.clientX + "px";
            glow.style.top = e.clientY + "px";
        }
    });

    const buttons = document.querySelectorAll(".fancy-btn, .main-btn, .toggle-btn, .card");

    buttons.forEach((item) => {
        item.addEventListener("mousemove", (e) => {
            const rect = item.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = ((y - centerY) / centerY) * -5;
            const rotateY = ((x - centerX) / centerX) * 5;

            item.style.transform = `perspective(700px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
        });

        item.addEventListener("mouseleave", () => {
            item.style.transform = "";
        });
    });
});
document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", () => {
        const btn = form.querySelector("button");
        if (btn) {
            btn.innerText = "Processing...";
            btn.disabled = true;
        }
    });
});