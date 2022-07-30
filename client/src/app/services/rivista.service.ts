import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class RivistaService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  get(slug: string) {
    return this.http.get(`${this.api}/rivistas/${slug}`);
  }

  paginate(page: number = 1) {
    return this.http.get(`${this.api}/rivistas`, { params: { page } });
  }

  new(rivista: any) {
    return this.http.post(`${this.api}/rivistas`, rivista);
  }
}
