export default function graficoCircular(theme) {
  const ctx = document.querySelector('#graficoCircular');

  if (ctx) {
    fetch('../php/get_financeiro.php')
      .then(response => response.json())
      .then(financeiro => {
        const totalEntrada = parseFloat(financeiro.total_entrada);
        const totalDebito = parseFloat(financeiro.total_debito);
        const restante = parseFloat(financeiro.restante);

        // Definir a cor do restante com base na condição
        const restanteColor = (restante / totalEntrada) < 0.7 ? 'rgba(255, 99, 132, 0.5)' : 'rgba(75, 192, 192, 0.5)'; // Vermelho se menos de 70%, caso contrário verde
        const restanteBorderColor = (restante / totalEntrada) < 0.7 ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)';

        Chart.defaults.color = theme;

        let graficoCircular = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Entrada', 'Débitos', 'Restante'],
            datasets: [{
              label: 'Percentual de gastos',
              data: [totalEntrada, totalDebito, restante],
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
            plugins: {
              legend: {
                display: true,
                position: 'top',
                labels: {
                  color: theme,
                  font: {
                    size: 14,
                    weight: 'bold'
                  }
                }
              },
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
              },
              datalabels: {
                formatter: function(value) {
                  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
                },
                color: theme,
                font: {
                  size: 12,
                  weight: 'bold'
                }
              }
            },
            animation: {
              duration: 1000,
              easing: 'easeInOutQuad'
            }
          }
        });
      })
      .catch(error => console.error('Erro ao buscar dados financeiros:', error));
  } else {
    console.error('Elemento canvas não encontrado');
  }
}