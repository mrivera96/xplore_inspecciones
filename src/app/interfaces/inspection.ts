import { State } from "./state";

export interface Inspection {
  idInspeccion?: number;
  idCliente?: number;
  idVehiculo?: number;
  idAgenciaSalida?: number;
  combSalida?: number;
  rendCombSalida?: number;
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
  nomRecibeVehiculo?: string;
  nomEntregaVehiculo?: string;
  idEstado?: number;
  fechaProceso?: string;
  vehiculo?: any;
  agencia_salida?: any;
  estado?: State
  daniosSalida?: string
}
