function validate(){
    const x = document.getElementById("phoneno");
    const y = document.getElementById("password");

    // either field empty is a problem - the old check only caught both being empty
    if (x.value === "" || y.value === "") {
        window.alert("please fill up the form properly!");
        return false;
    }
    return true;
}
