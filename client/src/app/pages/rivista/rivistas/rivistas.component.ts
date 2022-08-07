import { Component, OnInit } from '@angular/core';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-rivistas',
  templateUrl: './rivistas.component.html',
  styleUrls: ['./rivistas.component.scss'],
})
export class RivistasComponent implements OnInit {
  rivistas: any = null;
  pageConfig: any = {
    id: 'user-pagination',
    itemsPerPage: 0,
    currentPage: 1,
    totalItems: 0,
  };
  selected = 'likes';

  constructor(private rivistaService: RivistaService) {}

  ngOnInit(): void {
    this.changePage(this.pageConfig.currentPage);
  }

  changePage(page: number) {
    this.pageConfig.currentPage = page;

    if (this.selected == 'likes')
      this.rivistaService.paginateByLikes(page).subscribe((response: any) => {
        this.fillData(response);
      });
    else
      this.rivistaService.paginateByViews(page).subscribe((response: any) => {
        this.fillData(response);
      });
  }

  fillData(response: any) {
    this.pageConfig.currentPage = response.data.current_page;
    this.pageConfig.totalItems = response.data.total;
    this.pageConfig.itemsPerPage = response.data.per_page;
    this.rivistas = response.data.data;
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth',
    });
  }

  getByLikes() {
    this.selected = 'likes';
    this.changePage(this.pageConfig.currentPage);
  }

  getByViews() {
    this.selected = 'views';
    this.changePage(this.pageConfig.currentPage);
  }
}
