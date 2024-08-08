document.getElementById('submitBtn').addEventListener('click', function() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var idNumber = document.getElementById('id_number').value;
    var creditNumber = document.getElementById('credit_number').value;
    var paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    var creditCardNumber = paymentMethod && paymentMethod.value === 'credit_card' ? document.querySelector('input[name="credit_card_number"]').value : '';

    var errorMessages = [];

    // 驗證姓名
    if (name.trim() === '') {
        errorMessages.push('請輸入姓名');
    }

    // 驗證 Email
    if (email.trim() === '') {
        errorMessages.push('請輸入 Email');
    } else if (!validateEmail(email)) {
        errorMessages.push('請輸入有效的 Email');
    }

    // 驗證手機
    if (phone.trim() === '') {
        errorMessages.push('請輸入手機');
    } else if (!validatePhone(phone)) {
        errorMessages.push('請輸入有效的手機號碼');
    }

    // 驗證身分證字號
    if (idNumber.trim() === '') {
        errorMessages.push('請輸入身分證字號');
    } else if (!validateIDNumber(idNumber)) {
        errorMessages.push('請輸入有效的身分證字號');
    }


    // 驗證付款方式
    if (!paymentMethod) {
        errorMessages.push('請選擇付款方式');
    }else if (paymentMethod.value === 'credit_card' && creditCardNumber.trim() === '') {
        errorMessages.push('請輸入信用卡卡號');
    }

    if (errorMessages.length > 0) {
        alert(errorMessages.join('\n'));
        return;
    }

    // 模擬向伺服器發送請求並獲取訂單編號
    var orderNumber = "123456"; // 假設這是從伺服器獲取的訂單編號

    // 顯示模態框
    var modal = document.getElementById('modal');
    var modalText = document.getElementById('modal-text');
    modalText.innerHTML = `
        <div style="text-align: center;">
            謝謝您的訂購！<br>
            您的訂單編號是：
            ${orderNumber}
        </div>`;
    modal.style.display = "block";
});

// 關閉模態框
document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('modal').style.display = "none";
});

// 點擊模態框外部區域來關閉模態框
window.addEventListener('click', function(event) {
    var modal = document.getElementById('modal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
});

// 驗證 Email 格式
function validateEmail(email) {
    var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}

// 驗證手機號碼格式
function validatePhone(phone) {
    var re = /^[0-9]{10}$/;
    return re.test(phone);
}

// 驗證身分證字號格式
function validateIDNumber(idNumber) {
    var re = /^[A-Z][12]\d{8}$/;
    return re.test(idNumber);
}

// 驗證信用卡號格式
function validateCreditNumber(creditNumber) {
    var re =/^[0-9]{16}$/;
    return re.test(creditNumber);
}
