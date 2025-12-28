// Sidebar toggle for mobile
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('sidebarToggle');

toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('show');
  document.body.classList.toggle('sidebar-open');
});

// Navigation links to show/hide sections
function showSection(sectionId, element) {
  // Sections
  const sections = ['dashboard-section', 'daily-section', 'monthly-section', 'overall-section'];
  sections.forEach(id => {
    document.getElementById(id).style.display = (id === sectionId + '-section') ? 'block' : 'none';
  });

  // Update active nav-link
  document.querySelectorAll('nav a.nav-link').forEach(link => {
    link.classList.remove('active');
  });
  element.classList.add('active');

  // Close sidebar on mobile after click
  if (window.innerWidth < 992) {
    sidebar.classList.remove('show');
    document.body.classList.remove('sidebar-open');
  }
}

// Initialize last updated date
function updateDate() {
  const dateElement = document.getElementById('updated-date');
  const now = new Date();
  dateElement.textContent = now.toLocaleDateString(undefined, {
    year: 'numeric', month: 'short', day: 'numeric'
  });
}

updateDate();

// Chart.js setup
const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
const doughnutChart = new Chart(doughnutCtx, {
  type: 'doughnut',
  data: {
    labels: ['Zone 8', 'Casiguran', 'Managa', 'Naga'],
    datasets: [{
      data: [125000, 98000, 77000, 52000],
      backgroundColor: [
        'rgba(107, 70, 255, 0.8)',
        'rgba(124, 58, 237, 0.8)',
        'rgba(20, 184, 166, 0.8)',
        'rgba(16, 185, 129, 0.8)'
      ],
      borderWidth: 0
    }]
  },
  options: {
    cutout: '70%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: { color: '#475569', font: { weight: '600' } }
      },
      tooltip: {
        enabled: true,
        backgroundColor: '#2c3e50',
        titleFont: { weight: '600' },
        bodyFont: { weight: '400' }
      }
    },
    responsive: true,
    maintainAspectRatio: false,
  }
});

const barCtx = document.getElementById('barChart').getContext('2d');
const barChart = new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
    datasets: [{
      label: 'Sales (₱)',
      data: [50000, 60000, 55000, 70000, 65000, 75000],
      backgroundColor: 'rgba(107, 70, 255, 0.8)',
      borderRadius: 5,
      maxBarThickness: 35,
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: { color: '#64748b' }
      },
      x: {
        ticks: { color: '#64748b' }
      }
    },
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#2c3e50',
        titleFont: { weight: '600' },
        bodyFont: { weight: '400' }
      }
    },
    responsive: true,
    maintainAspectRatio: false,
  }
});

document.querySelectorAll('.chips .chip').forEach(chip => {
  chip.addEventListener('click', () => {
    document.querySelectorAll('.chips .chip').forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    // Add logic to update the daily sales data based on branch selected
  });
});
