package sena.adso.parqueadero.servlet;

import sena.adso.parqueadero.dao.RegistroDAO;
import sena.adso.parqueadero.model.Registro;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.time.LocalDate;
import java.util.List;
import java.util.Locale;

public class RegistroServlet extends HttpServlet {

    private final RegistroDAO dao = new RegistroDAO();
    Registro regis = new Registro();

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {

        resp.setContentType("application/json;charset=UTF-8");
        PrintWriter out = resp.getWriter();
        String path = req.getPathInfo();
        List<Registro> lista;

        try {

            if (path != null && path.endsWith("/reporte")) {
                List<Registro> listarH = dao.listarTarifaDia();
                double total = 0.0;
                int returnL = listarH.size();

                for (Registro r : listarH) {
                    if (r.getTarifa() > 0.0) {
                        total += r.getTarifa();
                    }
                }

                String fechaActual = java.time.LocalDate.now().toString();

                String jsonReporte = String.format(Locale.US,
                        "{\"total\": %.2f, \"cantidad\": %d, \"fecha\": \"%s\"}",
                        total, returnL, fechaActual
                );

                out.print(jsonReporte);

            } else {
                String estado = req.getParameter("estado");
                
                if ("FINALIZADO".equalsIgnoreCase(estado)) {
                    String desde = req.getParameter("desde");
                    String hasta = req.getParameter("hasta");
                    String tipo = req.getParameter("tipo");
                    
                    if (desde != null && hasta != null) {
                        lista = dao.listarPorParametros(desde, hasta, tipo);
                    } else {
                        lista = dao.listarHistorial();
                    }
                } else {
                    lista = dao.listarActivos();
                }
                
                StringBuilder sb = new StringBuilder("[");
                for (int i = 0; i < lista.size(); i++) {
                    if (i > 0) {
                        sb.append(",");
                    }
                    sb.append(lista.get(i).toJson());
                }
                sb.append("]");
                out.print(sb); 
            }

        } catch (Exception e) {
            resp.setStatus(HttpServletResponse.SC_INTERNAL_SERVER_ERROR);
            out.print("{\"error\":\"" + e.getMessage() + "\"}");
        }
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {
        resp.setContentType("application/json;charset=UTF-8");
        PrintWriter out = resp.getWriter();

        try {
            String body = leerBody(req);
            int vehiculoId = Integer.parseInt(extraerValorNumerico(body, "vehiculoId"));

            int registroActivo = dao.obtenerRegistroActivo(vehiculoId);
            if (registroActivo > 0) {
                resp.setStatus(409);
                out.print("{\"error\":\"El vehículo ya se encuentra en el parqueadero\", \"registroActivo\":" + registroActivo + "}");
                return; 
            }

            int nuevoId = dao.registrarEntrada(vehiculoId);

            if (nuevoId > 0) {
                resp.setStatus(HttpServletResponse.SC_CREATED);
                out.print("{\"mensaje\":\"Entrada registrada\",\"registroId\":" + nuevoId + "}");
            } else {
                resp.setStatus(HttpServletResponse.SC_INTERNAL_SERVER_ERROR);
                out.print("{\"error\":\"No se pudo registrar la entrada\"}");
            }
        } catch (Exception e) {
            resp.setStatus(HttpServletResponse.SC_INTERNAL_SERVER_ERROR);
            out.print("{\"error\":\"" + e.getMessage() + "\"}");
        }
    }

    @Override
    protected void doPut(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {

        resp.setContentType("application/json;charset=UTF-8");
        PrintWriter out = resp.getWriter();

        try {
            String path = req.getPathInfo();
            String[] partes = path.split("/");
            int registroId = Integer.parseInt(partes[1]);

            Registro reg = dao.registrarSalida(registroId);

            if (reg != null) {
                out.print(reg.toJson());
            } else {
                resp.setStatus(HttpServletResponse.SC_NOT_FOUND);
                out.print("{\"error\":\"Registro no encontrado o ya finalizado\"}");
            }

        } catch (Exception e) {
            resp.setStatus(HttpServletResponse.SC_INTERNAL_SERVER_ERROR);
            out.print("{\"error\":\"" + e.getMessage() + "\"}");
        }
    }

    private String leerBody(HttpServletRequest req) throws IOException {
        StringBuilder sb = new StringBuilder();
        try (BufferedReader br = req.getReader()) {
            String linea;
            while ((linea = br.readLine()) != null) {
                sb.append(linea);
            }
        }
        return sb.toString();
    }

    private String extraerValorNumerico(String json, String clave) {
        String patron = "\"" + clave + "\":";
        int inicio = json.indexOf(patron);
        if (inicio == -1) {
            return "0";
        }
        inicio += patron.length();
        int fin = inicio;
        while (fin < json.length() && (Character.isDigit(json.charAt(fin)))) {
            fin++;
        }
        return json.substring(inicio, fin);
    }
}
