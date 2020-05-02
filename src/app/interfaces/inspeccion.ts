export interface Inspeccion {
  idCliente?: number;
  idVehiculo?: number;
  idAgenciaSalida?: number;
  combSalida?: number;
  redCombSalida?: number;
  odoSalida?: number;
  fechaSalida?: string;
  idUsuarioSalida?: number;
  firmaClienteSalida?: string;
  obsSalida?: string;
  idAgenciaEntrega?: number;
  combEntrega?: number;
  rendCombEntrega?: number;
  odoEntrega?: number;
  fechaEntrega?: string;
  idUsuarioEntrega?: number;
  firmaClienteEntrega?: string;
  obsEntrega?: string;
  nomRecibeVehicul?: string;
  nomEntregaVehiculo?: string;
  idEstado?: number;
  fechaProceso?: string;
}
