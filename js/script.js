const view = document.querySelectorAll(".view");

view.forEach(v => {
    v.addEventListener('click', ()=>{
        if (v.classList.contains('active')){
            v.classList.remove('active');
            v.previousElementSibling.setAttribute('type', 'password');
        }else {
            v.classList.add('active');
            v.previousElementSibling.setAttribute('type', 'text');
        }
    })
});
