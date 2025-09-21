<aside>
    <div class="select-icon" data-page="index.php">
        <a href="index.php">
            <span class="material-symbols-rounded">home</span>
        </a>
    </div>

    <div class="select-icon" data-page="search.php">
        <a href="search.php">
            <span class="material-symbols-rounded">search</span>
        </a>
    </div>

    <div class="select-icon" data-page="leaderboard.php">
        <a href="leaderboard.php">
            <span class="material-symbols-rounded">trophy</span>
        </a>
    </div>

    <div class="select-icon" data-page="config.php">
        <a href="config.php">
            <span class="material-symbols-rounded">settings</span>
        </a>
    </div>
</aside>


<script>
document.querySelectorAll(".select-icon a").forEach(link => {
    link.addEventListener("click", () => {
        const parent = link.closest(".select-icon");
        localStorage.setItem("lastClicked", parent.dataset.page);
    });
});

const currentPage = window.location.pathname.split("/").pop();
const lastClicked = localStorage.getItem("lastClicked");

const icons = document.querySelectorAll(".select-icon");
let matched = false;

icons.forEach(icon => {
    if (icon.dataset.page === currentPage) {
        icon.classList.add("select-icon-true");
        matched = true;

        if (icon.dataset.page === lastClicked) {
            icon.classList.add("fade-in");
            localStorage.removeItem("lastClicked");
        }
    }
});

if (!matched && currentPage === "") {
    const firstIcon = icons[0];
    if (firstIcon) {
        firstIcon.classList.add("select-icon-true");

        if (firstIcon.dataset.page === lastClicked) {
            firstIcon.classList.add("fade-in");
            localStorage.removeItem("lastClicked");
        }
    }
}

</script>