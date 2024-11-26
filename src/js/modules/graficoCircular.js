export default function graficoCircular(theme) {
  const ctx = document.querySelector('#graficoCircular');

  if (ctx) {
    fetch('../php/get_financeiro.php')
      .then(response => response.json())
      .then(financeiro => {
        const totalEntrada = parseFloat(financeiro.total_entrada);
        const totalDebito = parseFloat(financeiro.total_debito);
        const restante = parseFloat(financeiro.restante);

        Chart.defaults.color = theme;

        let graficoCircular = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Entrada', 'Débitos', 'Restante'],
            datasets: [{
              label: 'Percentual de gastos',
              data: [totalEntrada, totalDebito, restante],
              backgroundColor: [
                'rgba(3, 60, 158, 0.5)',  // Entrada - Azul Forte
                'rgba(199, 120, 2, 0.5)',  // Débitos - Vermelho Forte
                'rgba(2, 120, 9, 0.5)',  // Restante - Verde Forte
              ],
              borderColor: [
                'rgba(3, 60, 158, 1)',  // Entrada - Azul Forte
                'rgba(199, 120, 2, 1)',  // Débitos - Vermelho Forte
                'rgba(2, 120, 9, 1)',  // Restante - Verde Forte
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              tooltip: {
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    if (context.parsed !== null) {
                      label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed);
                    }
                    return label;
                  }
                }
              }
            }
          }
        });
      })
      .catch(error => console.error('Erro ao buscar dados financeiros:', error));
  }
}