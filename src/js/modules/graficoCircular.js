export default function graficoCircular(){
  
  const ctx = document.getElementById('graficoCircular');


  let graficoBarra = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['entrada', 'debitos', 'restante'],
      datasets: [{
        label: 'Percentual de gastos',
        data: [1500, 800, 700],
        backgroundColor: [
          'rgba(2, 110, 9, 0.9)',  // Entrada Total - Verde Forte (representa entrada positiva)
          'rgba(199, 100, 2, 0.9)',  // Débitos - Vermelho Forte (representa despesas e saídas)
          'rgba(3, 1, 158, 0.9)',  // Restante - Azul Forte (representa o saldo restante ou o que sobra)
        ],
        borderColor: [
          'rgb(2, 110, 9)',  // Entrada Total - Verde Forte (representa entrada positiva)
          'rgb(199, 100, 2)',  // Débitos - Vermelho Forte (representa despesas e saídas)
          'rgb(3, 1, 158)',  // Restante - Azul Forte (representa o saldo restante ou o que sobra)
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