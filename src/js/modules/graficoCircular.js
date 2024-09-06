export default function graficoCircular(){
  
  const ctx = document.getElementById('graficoCircular');


  let graficoBarra = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Entrada', 'Debitos', 'Restante'],
      datasets: [{
        label: 'Percentual de gastos',
        data: [1500, 800, 700],
        backgroundColor: [
          'rgba(3, 60, 158, 0.5)',  // Entradada - Azul Forte (representa a Entrada Total)
          'rgba(199, 120, 2, 0.5)',  // Débitos - Vermelho Forte (representa despesas e saídas)
          'rgba(2, 120, 9, 0.5)',  // Restante Total - Verde Forte (representa Restante positivo)
        ],
        borderColor: [
          'rgba(3, 1, 0.8, 0.5)',  // Entradada - Azul Forte (representa a Entrada Total)
          'rgba(199, 20, 0.7, 0.5)',  // Débitos - Vermelho Forte (representa despesas e saídas)
          'rgba(2, 20, 0.7, 0.5)',  // Restante Total - Verde Forte (representa Restante positivo)
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  
}