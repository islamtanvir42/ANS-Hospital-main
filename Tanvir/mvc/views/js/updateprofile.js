function upvalidate(){
    const name = document.getElementById("fullname");
    const email = document.getElementById("email");
    const gender = document.getElementById("gender");
    const mobile = document.getElementById("mobile");

    if (name.value === "" || email.value === "" || gender.value === "" || mobile.value === "") {
        window.alert("please fill up the form properly!");
        return false;
    }
    return true;
}
