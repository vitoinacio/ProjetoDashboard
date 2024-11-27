export default function graficoCircular(theme) {
  const ctx = document.querySelector('#graficoCircular');

  if (ctx) {
    fetch('../php/get_financeiro.php')
      .then(response => response.json())
      .then(financeiro => {
        const totalEntrada = parseFloat(financeiro.total_entrada);
        const totalDebito = parseFloat(financeiro.total_debito);
        const restante = parseFloat(financeiro.restante);
        const total = totalEntrada + totalDebito + restante;

        // Calcular as porcentagens
        const percentualEntrada = ((totalEntrada / total) * 100).toFixed(2);
        const percentualDebito = ((totalDebito / total) * 100).toFixed(2);
        const percentualRestante = ((restante / total) * 100).toFixed(2);

        // Definir a cor do restante com base na condição
        const restanteColor = (percentualRestante > 70) ? 'rgba(255, 99, 132, 0.5)' : 'rgba(75, 192, 192, 0.5)'; // Vermelho se mais de 70%, caso contrário verde
        const restanteBorderColor = (percentualRestante > 70) ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)';

        Chart.defaults.color = theme;

        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Entrada', 'Débitos', 'Restante'],
            datasets: [{
              label: 'Percentual de gastos',
              data: [percentualEntrada, percentualDebito, percentualRestante],
              backgroundColor: [
                'rgba(54, 162, 235, 0.7)',  // Entrada - Azul Escuro
                'rgba(255, 159, 64, 0.7)',  // Débitos - Laranja Moderno
                restanteColor  // Restante - Verde ou Vermelho Moderno
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',  // Entrada - Azul Escuro
                'rgba(255, 159, 64, 1)',  // Débitos - Laranja Moderno
                restanteBorderColor  // Restante - Verde ou Vermelho Moderno
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                labels: {
                  color: theme === '#fff' ? '#000' : '#fff' // Ajustar cor do texto com base no tema
                }
              },
              datalabels: {
                color: theme === '#fff' ? '#000' : '#fff', // Ajustar cor do texto com base no tema
                formatter: (value, context) => {
                  const percentage = value.toFixed(2) + '%';
                  return percentage;
                }
              }
            }
          }
        });
      })
      .catch(error => console.error('Erro ao buscar dados financeiros:', error));
  }
}