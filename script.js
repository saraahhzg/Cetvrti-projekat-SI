document.querySelector("form").addEventListener("submit", function(e) {
    let email = document.querySelector("input[name='email']").value;
    if(!email.includes("@")) {
        alert("Email nije validan!");
        e.preventDefault();
    }
});