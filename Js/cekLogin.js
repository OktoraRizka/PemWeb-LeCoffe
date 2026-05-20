const usernameInput = document.getElementById('username') || document.getElementById('nama');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const alamatInput = document.getElementById('alamat');
const tombolCek = document.getElementById('tombolCek');

const namaEr = document.getElementById("namaError");
const emailEr = document.getElementById("emailError");
const passEr = document.getElementById("passwordHPError");
const AlamatEr = document.getElementById("alamatError");

function validasiForm() {
    let isValid = true; 

    if (usernameInput) {
        if (usernameInput.value.trim() === "") {
            usernameInput.style.borderColor = "#FF3737";
            if (namaEr) {
                namaEr.textContent = "Username masih kosong!";
                namaEr.style.color = "#FF3737";
            }
            isValid = false;
        } else {
            usernameInput.style.borderColor = "#91D06C";
            if (namaEr) {
                namaEr.textContent = ".";
                namaEr.style.color = "transparent";
            }
        }
    }

    if (emailInput) {
        if (emailInput.value.trim() === "") {
            emailInput.style.borderColor = "#FF3737";
            if (emailEr) {
                emailEr.textContent = "Email masih kosong!";
                emailEr.style.color = "#FF3737";
            }
            isValid = false;
        } else {
            emailInput.style.borderColor = "#91D06C";
            if (emailEr) {
                emailEr.textContent = ".";
                emailEr.style.color = "transparent";
            }
        }
    }

    if (passwordInput) {
        if (passwordInput.value.trim() === "") {
            passwordInput.style.borderColor = "#FF3737";
            if (passEr) {
                passEr.textContent = "Password masih kosong!";
                passEr.style.color = "#FF3737";
            }
            isValid = false;
        } else {
            passwordInput.style.borderColor = "#91D06C";
            if (passEr) {
                passEr.textContent = ".";
                passEr.style.color = "transparent";
            }
        }
    }

    if (alamatInput) {
        if (alamatInput.value.trim() === "") {
            alamatInput.style.borderColor = "#FF3737";
            if (AlamatEr) {
                AlamatEr.textContent = "Alamat harus diisi!";
                AlamatEr.style.color = "#FF3737";
            }
            isValid = false;
        } else {
            alamatInput.style.borderColor = "#91D06C";
            if (AlamatEr) {
                AlamatEr.textContent = ".";
                AlamatEr.style.color = "transparent";
            }
        }
    }

    return isValid; 
}

if (tombolCek) {
    tombolCek.addEventListener('click', function(event) {
        const isFormValid = validasiForm();

        if (!isFormValid) {
            event.preventDefault(); 
        } else {
            console.log("Form valid, memproses data...");
        }
    });
}