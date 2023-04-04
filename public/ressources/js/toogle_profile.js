
// Start Toggle Header profile
let togglePannerNav = document.querySelector('#profile');
let showPannerNav = document.querySelector('#profile_menu');

togglePannerNav.addEventListener('click', (e) => {
    e.preventDefault();
    if(showPannerNav.classList=="show"){
        showPannerNav.classList.remove("show");
        
    }else{
        showPannerNav.classList.add("show")
    }
});
