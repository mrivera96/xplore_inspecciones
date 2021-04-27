import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {Agency} from "../../../interfaces/agency";

@Component({
  selector: 'app-resume-dialog',
  templateUrl: './resume-dialog.component.html',
  styleUrls: ['./resume-dialog.component.css']
})
export class ResumeDialogComponent implements OnInit {
  inspection: any
  agencies: Agency[]
  constructor(
    @Inject(MAT_DIALOG_DATA) public data: any,
    public dialogRef: MatDialogRef<ResumeDialogComponent>,
  ) {
    this.inspection = this.data.inspection
    this.agencies = this.data.agencies
    this.dialogRef.disableClose = true
  }

  ngOnInit(): void {
  }

  getDesc(array?, index?) {
    if (array) {
      const item = array[index-1]
      return item
    }
  }

  formatLabel(value: number | null) {
    switch (value) {
      case 0: {
        return 'E'
        break
      }
      case 8: {
        return 'F'
        break
      }
      case 9: {
        return 'F+'
        break
      }
      default: {
        return value + '/8'
      }

    }
  }

}
