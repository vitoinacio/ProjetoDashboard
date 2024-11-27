export default function graficoDeBarra(theme) {
  const ctx = document.querySelector("#graficoDeBarra");

  if (ctx) {
    fetch('../php/get_debitos.php')
      .then(response => response.json())
      .then(debitos => {
        let valoresPorMes = Array(12).fill(0);

        debitos.forEach(debito => {
          let dataVenc = new Date(debito.data_venc);
          let mes = dataVenc.getMonth(); // Janeiro é 0, Fevereiro é 1, etc.
          valoresPorMes[mes] += parseFloat(debito.valor_deb);
        });

        Chart.defaults.color = theme;

        let graficoBarra = new Chart(ctx, {
          type: "bar",
          data: {
            labels: [
              "Jan",
              "Fev",
              "Mar",
              "Abr",
              "Mai",
              "Jun",
              "Jul",
              "Ago",
              "Set",
              "Out",
              "Nov",
              "Dez"
            ],
            datasets: [
              {
                label: "Débitos por Mês",
                data: valoresPorMes,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 10,
                borderSkipped: false
              }
            ]
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
                    let label = context.dataset.label || '';
                    if (label) {
                      label += ': ';
                    }
                    if (context.parsed.y !== null) {
                      label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                    }
                    return label;
                  }
                }
              },
              datalabels: {
                anchor: 'end',
                align: 'end',
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
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  color: theme === '#fff' ? '#000' : '#fff', // Ajustar cor do texto com base no tema
                  callback: function(value) {
                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
                  }
                },
                grid: {
                  color: 'rgba(200, 200, 200, 0.2)'
                }
              },
              x: {
                ticks: {
                  color: theme === '#fff' ? '#000' : '#fff'
                },
                grid: {
                  color: 'rgba(200, 200, 200, 0.2)'
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
      .catch(error => console.error('Erro ao buscar débitos:', error));
  }
}