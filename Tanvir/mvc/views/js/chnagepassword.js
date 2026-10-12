function changevalidate(){
    const current = document.getElementById("currentpassword");
    const next = document.getElementById("newpassword");

    if (current.value === "" || next.value === "") {
        window.alert("please fill up the form properly!");
        return false;
    }
    return true;
}
