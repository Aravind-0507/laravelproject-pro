
    const rowsPerPage = 10;
    let currentPage = 1;

    function searchTable() {
        const input = document.getElementById("search").value.toLowerCase();
        const rows = document.querySelectorAll("#employeeTableBody tr");
        let filteredRows = [];

        rows.forEach((row) => {
            const name = row.cells[1].innerText.toLowerCase();
            const email = row.cells[2].innerText.toLowerCase();

            if (name.includes(input) || email.includes(input)) {
                row.style.display = "";
                filteredRows.push(row);
            } else {
                row.style.display = "none";
            }
        });

        paginate(filteredRows);
    }

    function paginate(filteredRows) {
        const paginationDiv = document.getElementById("pagination");

        paginationDiv.innerHTML = "";
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);
        document.querySelectorAll("#employeeTableBody tr").forEach(row => {
            row.style.display = "none";
        });
        visibleRows.forEach(row => {
            row.style.display = "";
        });
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.innerText = i;
            button.classList.add("btn", "btn-secondary", "mx-1");
            button.onclick = function () {
                currentPage = i;
                paginate(filteredRows);
            };
            paginationDiv.appendChild(button);
        }
    }
    document.addEventListener("DOMContentLoaded", () => {
        searchTable();
    });
    document.querySelector('.profile-dropdown').addEventListener('click', function () {
        const dropdownMenu = this.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });
    window.addEventListener('click', function (event) {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (!event.target.matches('.profile-dropdown') && dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        }
    });


    document.getElementById('profile-icon').addEventListener('click', function () {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });
    window.addEventListener('click', function (event) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (!event.target.matches('#profile-icon') && dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        }
    });