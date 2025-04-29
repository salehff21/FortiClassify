// ملف عام لعرض الرسائل باستخدام SweetAlert2
function showAlert(type, message, redirectUrl = null) {
    Swal.fire({
        icon: type, // success, error, warning, info
        title: message,
        showConfirmButton: true
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl; // إعادة التوجيه بعد إغلاق الرسالة
        }
    });
}
