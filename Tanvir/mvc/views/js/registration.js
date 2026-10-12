function Regvalidate(){
    const a = document.getElementById("fullename");
    const b = document.getElementById("email");
    const c = document.getElementById("phoneno");
    const d = document.getElementById("password");
    const e = document.getElementById("confirmpassword");
    const f = document.querySelector('input[name="gender"]:checked');

    // the old check read .value of the first gender radio, which is never empty
    if (a.value === "" || b.value === "" || c.value === "" || d.value === "" || e.value === "" || !f) {
        window.alert("please fill up the form properly!");
        return false;
    }
    return true;
}
